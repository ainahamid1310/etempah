
    let suppressAvailabilityCheck = false;

    function removeDateError(e) {
        const input = e.target;

        // Buang class is-invalid jika ada (optional kalau anda guna)
        input.classList.remove('is-invalid');

        // Cari elemen error icon (input-group-append) dalam input-group dan buang
        const group = input.closest('.input-group');
        if (!group) return;

        const errorIcon = group.querySelector('.input-group-append');
        if (errorIcon) {
            errorIcon.remove();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {

        function removeError(e) {
            const target = e.target;
            target.classList.remove('is-invalid');

            const feedback = target.closest('.form-group')?.querySelector('.invalid-feedback');
            if (feedback) {
                feedback.style.display = 'none';
            }
        }
        
        // Semua input, select, textarea biasa
        document.querySelectorAll('input, select, textarea').forEach(function (el) {
            el.addEventListener('input', removeError);
            el.addEventListener('change', removeError);
        });

        // Untuk select2 sahaja
        if (typeof $ !== 'undefined' && $.fn.select2) {
            $('.select-search').on('select2:select', function () {
                const select = $(this);
                select.removeClass('is-invalid');
                select.next('.select2-container').find('.select2-selection').removeClass('is-invalid');
                select.closest('.form-group').find('.invalid-feedback').hide();
            });
        }    
        
        // SEMAKAN SUSUNAN TARIKH BILA TARIKH DITUKAR
        document.querySelectorAll('input[name^="bookings"]').forEach(function (el) {
                el.addEventListener('change', function (e) {
                removeDateError(e);            // ✅ Buang error sebelum ini
                markInvalidSequenceRows();     // ✅ Semak susunan tarikh terkini
            });
        });

        // function removeDateError(e) {
        //     const input = e.target;

        //     // Buang class is-invalid jika ada (optional kalau anda guna)
        //     input.classList.remove('is-invalid');

        //     // Cari elemen error icon (input-group-append) dalam input-group dan buang
        //     const group = input.closest('.input-group');
        //     if (!group) return;

        //     const errorIcon = group.querySelector('.input-group-append');
        //     if (errorIcon) {
        //         errorIcon.remove();
        //     }
        // }
        
    });


    function kategoriPengerusi() {

        var kategori_pengerusi = document.getElementById("kategori_pengerusi").value;
        var pengerusi = document.getElementById("div_pengerusi");

        if (kategori_pengerusi == "0") {
            pengerusi.style.display = "block";
        } else {
            pengerusi.style.display = "none";
        }
    }

    function alert_nama_penganjur() {

        var penganjur = document.getElementById("penganjur").value;
        var nama_penganjur = document.getElementById("div_nama_penganjur");

        if (penganjur == "BERSAMA" || penganjur == "LUAR") {
            nama_penganjur.style.display = "block";
        } else {
            nama_penganjur.style.display = "none";
        }
    }

    function sajianSelected(select_item) {

        if (select_item == "Katerer Luar") {
            div_sajian.style.display = 'block';
            div_minum_pagi.style.display = 'block';
            div_makan_tengahari.style.display = 'block';
            div_minum_petang.style.display = 'block';
            // document.getElementById("mesej_sajian_dalaman").style.display = "none";

        } else if (select_item == "Pantri Dalaman") {
            div_sajian.style.display = 'block';
            div_minum_pagi.style.display = 'block';
            div_minum_petang.style.display = 'block';
            div_makan_tengahari.style.display = 'none';
            // document.getElementById("mesej_sajian_dalaman").style.display = "block";

        } else if (select_item == "Tidak Perlu") {
            div_sajian.style.display = 'none';
            // document.getElementById("mesej_sajian_dalaman").style.display = "none";
        }
    }

    function webexSelected() {
        var webex_ya = document.getElementById("ya");
        var webex_tidak = document.getElementById("tidak");
        var div_nama_aplikasi = document.getElementById("div_nama_aplikasi");

        if (webex_ya.checked == true) {
            div_nama_aplikasi.style.display = 'none';
        }
        if (webex_tidak.checked == true) {
            div_nama_aplikasi.style.display = 'block';
        }
    }

    function showHideForm() {
        var vc_selected = document.getElementById("vc_selected");
        var form_room_urusetia = document.getElementById("form_room_urusetia");
        var form_vc = document.getElementById("form_vc");

        if (vc_selected.checked == true) {
            form_vc.style.display = "block";
        } else {
            form_vc.style.display = "none";           
        }        
    }  

    function markInvalidSequenceRows() {
        console.log("1. Validasi susunan tarikh sedang dijalankan...");
        const rows = document.querySelectorAll('.booking-row');
        const bookings = [];
        let sequenceHasError = false;

        // Parser tarikh
        const parseDateOnly = (str) => {
            if (!str) return null;
            const [datePart] = str.split(' ');
            const [d, m, y] = datePart.split('/');
            const date = new Date(+y, m - 1, +d);
            date.setHours(0, 0, 0, 0);
            return date;
        };

        const today = new Date();
        today.setHours(0, 0, 0, 0);

        // Reset semua error
        document.querySelectorAll('.availability-status').forEach(span => {
            if (span.getAttribute('data-status') === 'sequence-error') {
                span.innerHTML = '';
                span.removeAttribute('data-status');
            }
        });
        document.querySelectorAll('.start-input, .end-input').forEach(inp => {
            inp.classList.remove('error-border');
        });

        // Kumpul data
        rows.forEach((r, idx) => {
            const startInput = r.querySelector('.start-input');
            const endInput = r.querySelector('.end-input');
            const s = startInput?.value;
            const e = endInput?.value;
            if (s && e) {
                const startDate = parseDateOnly(s);
                const endDate = parseDateOnly(e);
                const statusSpan = r.querySelector('.availability-status');

                // ❌ Tarikh lepas
                if ((startDate && startDate < today) || (endDate && endDate < today)) {
                    const message = `Tarikh mestilah hari ini/selepas hari ini`;
                    statusSpan.innerHTML = `<i class="fas fa-exclamation-triangle text-danger fa-lg" title="${message}"></i><span style="font-size: 9px; color: red;margin-left: 4px;">${message}</span>`;
                    statusSpan.setAttribute('data-status', 'sequence-error');
                    sequenceHasError = true;
                    // if (startDate < today) startInput?.classList.add('error-border');
                    // if (endDate < today) endInput?.classList.add('error-border');
                }

                // ❌ Start > End
                if (startDate && endDate && startDate > endDate) {
                    const message = `Tarikh tamat mesti selepas tarikh mula.`;
                    statusSpan.innerHTML = `<i class="fas fa-exclamation-triangle text-danger fa-lg" title="${message}"></i><span style="font-size: 9px; color: red;margin-left: 4px;">${message}</span>`;
                    statusSpan.setAttribute('data-status', 'sequence-error');
                    sequenceHasError = true;
                    // startInput?.classList.add('error-border');
                    // endInput?.classList.add('error-border');
                }

                bookings.push({ start: s, end: e, row: r });
            }
        });

        console.log("2. Semak susunan tarikh...");

        // ❌ Susunan mesti sequential
        for (let i = 1; i < bookings.length; i++) {
            const prevEnd = parseDateOnly(bookings[i - 1].end);
            const currStart = parseDateOnly(bookings[i].start);
            const row = bookings[i].row;
            const statusSpan = row.querySelector('.availability-status');

            if (!prevEnd || !currStart) continue;

            if (currStart <= prevEnd) {
                const message = `Tempoh baris ke-${i + 1} mesti mula selepas ${bookings[i - 1].end}`;
                statusSpan.innerHTML = `<i class="fas fa-exclamation-triangle text-danger fa-lg" title="${message}"></i><span style="font-size: 9px; color: red;margin-left: 4px;">${message}</span>`;
                statusSpan.setAttribute('data-status', 'sequence-error');
                sequenceHasError = true;

                const startInput = row.querySelector('.start-input');
                startInput?.classList.add('error-border');
            }
        }

        // Kawal butang tambah tarikh
        const addRowBtn = document.getElementById('addRow');
        if (addRowBtn) {
            if (sequenceHasError) {
                addRowBtn.classList.add('disabled');
            } else {
                addRowBtn.classList.remove('disabled');
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
      
        // init semua yang sedia ada masa load
        document.querySelectorAll('.start-input, .end-input').forEach(input => {
            flatpickr(input, {
                enableTime: true,
                dateFormat: "d/m/Y H:i",
                time_24hr: true,
                defaultDate: input.value || null
            });
        });

        // ===================== UTILITIES ===================== //

        function activateTab(tabId) {
            // clear semua dulu
            document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show', 'active'));

            const tabLink = document.querySelector(`a[href="${tabId}"]`);
            const tabPane = document.querySelector(tabId);

            if (tabLink && tabPane) {
                tabLink.classList.add('active');
                tabPane.classList.add('show', 'active');
            }
        }    

        // Format tarikh
        function formatTarikhDMY(tarikh) {
            const date = new Date(tarikh);
            if (isNaN(date)) return tarikh;
            return `${String(date.getDate()).padStart(2, '0')}/${String(date.getMonth() + 1).padStart(2, '0')}/${date.getFullYear()}`;
        }

        // ===================== TAB LOGIC ===================== //
        const nextBtn = document.getElementById("nextBtn");
        const nextBtn2 = document.getElementById("nextBtn2");
        const prevBtn = document.getElementById("prevBtn");
        const prevBtn2 = document.getElementById("prevBtn2");

        if (nextBtn) nextBtn.addEventListener("click", function (e) {
            e.preventDefault();

            const roomSelect = document.getElementById("room");
            const selectedOption = roomSelect.options[roomSelect.selectedIndex];
            const is_auto = selectedOption ? selectedOption.getAttribute('data-auto') : 'Y';

            // Kalau tab bilik disable, terus skip ke VC
            if (is_auto === 'N' || is_auto === 'S') {
                // lompat ke VC
                activateTab('#maklumat_vc');

                // pastikan content bilik tak aktif
                document.querySelector('#maklumat_bilik')?.classList.remove('show', 'active');
            } else {
                activateTab('#maklumat_bilik');
            }
        });

        if (nextBtn2) nextBtn2.addEventListener("click", function (e) {
            e.preventDefault();
            activateTab('#maklumat_vc');
        });

        if (prevBtn) prevBtn.addEventListener("click", function (e) {
            e.preventDefault();
            activateTab('#maklumat_permohonan');
        });

        if (prevBtn2) prevBtn2.addEventListener("click", function (e) {
            e.preventDefault();
            const room = document.getElementById("room")?.value || '';
            const is_auto = room.substr(room.length - 3, 1);
            activateTab((is_auto === 'N' || is_auto === 'S') ? '#maklumat_permohonan' : '#maklumat_bilik');
        });

        // ===================== BOOKING & FLATPICKR ===================== //
        const firstRow = document.querySelector('.booking-row');
        const bookingContainer = document.getElementById('booking-rows');
        let index = 1;

        function initFlatpickrForRow(row) {
            row.querySelectorAll('.start-input, .end-input').forEach(input => {
                flatpickr(input, {
                    enableTime: true,
                    dateFormat: "d/m/Y H:i",
                    time_24hr: true,
                    defaultDate: input.value || null
                });
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const roomSelect = document.getElementById('room');
            if (roomSelect) {
                roomSelect.addEventListener('change', function () {
                    const rows = document.querySelectorAll('.booking-row');
                    rows.forEach(row => {
                        const start = row.querySelector('.start-input')?.value;
                        const end = row.querySelector('.end-input')?.value;

                        if (start && end) {
                            checkAvailabilityIfReady(row);
                        } else {
                            const statusSpan = row.querySelector('.availability-status');
                            if (statusSpan) {
                                statusSpan.innerHTML = '';
                                statusSpan.removeAttribute('data-status');
                                console.log('Availability cleared sebab bilik ditukar tapi input kosong');
                            }
                        }
                    });
                    markInvalidSequenceRows();
                });
            }
        });

        function bindChangeEventToRow(row) {
            console.log("4. bindChangeEventToRow...");
            row.querySelectorAll('.start-input, .end-input').forEach(input => {
                ['change', 'input'].forEach(evt => {
                    input.addEventListener(evt, function (e) {
                        const start = row.querySelector('.start-input')?.value;
                        const end = row.querySelector('.end-input')?.value;
                        const statusSpan = row.querySelector('.availability-status');

                        if (!start || !end) {
                            if (statusSpan) {
                                statusSpan.innerHTML = '';
                                statusSpan.removeAttribute('data-status');
                                console.log('⏹ Cleared availability (empty input)');
                            }
                            return;
                        }

                        checkAvailabilityIfReady(row);
                        removeDateError(e);
                        markInvalidSequenceRows();
                    });
                });
            });
        }





        function checkAvailabilityIfReady(row) {
            fetch(window.checkAvailabilityUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    room_id: roomId,
                    start: start,
                    end: end
                })
            })
            .then(res => res.json())
            .then(data => {
                console.log("Availability response:", data);
                // 👉 sini boleh buat logik kalau bilik available / tak available
            })
            .catch(err => console.error("Fetch error:", err));








            
            console.log("5. checkAvailabilityIfReady...");
            if (suppressAvailabilityCheck) return;

            const startInput = row.querySelector('.start-input');
            const endInput = row.querySelector('.end-input');
            const start = startInput?.value;
            const end = endInput?.value;
            const roomId = document.getElementById('room')?.value;
            const statusSpan = row.querySelector('.availability-status');

            // 🔹 Reset status/error lama dulu
            if (statusSpan) {
                statusSpan.innerHTML = '';
                statusSpan.removeAttribute('data-status');
            }
            startInput?.classList.remove('error-border');
            endInput?.classList.remove('error-border');

            // Kalau input kosong → keluar awal
            if (!start || !end) return;

            // Parse tarikh + masa (format: dd/mm/yyyy HH:MM)
            const parseDateTime = (str) => {
                if (!str) return null;
                const [datePart, timePart] = str.split(' ');
                const [d, m, y] = datePart.split('/');
                const date = new Date(+y, m - 1, +d);

                if (timePart) {
                    const [hh, mm] = timePart.split(':');
                    date.setHours(+hh, +mm, 0, 0);
                } else {
                    date.setHours(0, 0, 0, 0);
                }
                return date;
            };

            const today = new Date();
            today.setHours(0, 0, 0, 0);

            const startDate = parseDateTime(start);
            const endDate = parseDateTime(end);

            // ✅ Semakan 1: Tarikh mesti ≥ hari ini
            if ((startDate && startDate < today) || (endDate && endDate < today)) {
                const message = "Tarikh mula / tamat tidak boleh sebelum hari ini.";
                if (startDate < today) startInput?.classList.add('error-border');
                if (endDate < today) endInput?.classList.add('error-border');

                statusSpan.innerHTML = `<i class="fas fa-exclamation-triangle text-danger fa-lg" title="${message}"></i><span style="font-size: 9px; color: red;margin-left: 4px;">${message}</span>`;
                statusSpan.setAttribute('data-status', 'date-error');
           
                return;
            }

            // ✅ Semakan 2: Start ≤ End 
            if (startDate && endDate && startDate >= endDate) {
                const message = "Tarikh tamat mesti selepas atau sama dengan tarikh mula.";
                startInput?.classList.add('error-border');
                endInput?.classList.add('error-border');

                statusSpan.innerHTML = `<i class="fas fa-exclamation-triangle text-danger fa-lg" title="${message}"></i><span style="font-size: 9px; color: red;margin-left: 4px;">${message}</span>`;
                statusSpan.setAttribute('data-status', 'date-error');

                return;
            }

            // ✅ Semakan 3: masa tamat mesti > masa mula
         
            if (startDate && endDate) {
                const startTime = startDate.getHours() * 60 + startDate.getMinutes();
                const endTime = endDate.getHours() * 60 + endDate.getMinutes();

                if (startTime >= endTime) {
                    const message = "Masa tamat mesti selepas masa mula.";
                    startInput?.classList.add('error-border');
                    endInput?.classList.add('error-border');

                    statusSpan.innerHTML = `<i class="fas fa-exclamation-triangle text-danger fa-lg" title="${message}"></i>
                        <span style="font-size: 9px; color: red; margin-left: 4px;">${message}</span>`;
                    statusSpan.setAttribute('data-status', 'time-error');
                    return;

                    const icon = statusSpan.querySelector('.error-icon');
                    if (icon) {
                        icon.addEventListener('click', () => {
                            alert("Sila pastikan masa tamat lebih lewat daripada masa mula (tidak melebihi 24 jam).");
                        });
                    }
                }
            }

            // ✅ Semakan 4: Urutan sequential (guna semua rows)
            const rows = document.querySelectorAll('.booking-row');
            const bookings = Array.from(rows).map(r => {
                return {
                    start: r.querySelector('.start-input')?.value,
                    end: r.querySelector('.end-input')?.value
                };
            });

            const parseDate = (dateStr) => {
                if (!dateStr) return null;
                const [day, month, year] = dateStr.split('/');
                return new Date(+year, month - 1, +day); // month 0-based
            };

            for (let i = 1; i < bookings.length; i++) {
                const prevEnd = parseDate(bookings[i - 1].end);
                const currentStart = parseDate(bookings[i].start);

                if (!prevEnd || !currentStart) continue;

                const expectedStart = new Date(prevEnd);
                expectedStart.setDate(expectedStart.getDate() + 1);

                if (currentStart < expectedStart) {
                    const message = `Tempoh baris ke-${i + 1} mestilah bermula selepas ${bookings[i - 1].end}`;
                    statusSpan.innerHTML = `<i class="fas fa-exclamation-triangle text-danger fa-lg" title="${message}"></i><span style="font-size: 9px; color: red;margin-left: 4px;">${message}</span>`;
                    statusSpan.setAttribute('data-status', 'time-error');

                    // highlight input
                    const rowError = rows[i];
                    rowError.querySelector('.start-input')?.classList.add('error-border'); 
                    return;
                }
            }

            // ✅ Semua lulus → baru check availability
            if (roomId) {
                debounceCheckAvailability(roomId, start, end, row);
            }
        }

        const kategoriPengerusiSelect = document.getElementById("kategori_pengerusi");
        if (kategoriPengerusiSelect) {
            kategoriPengerusi(); // Panggil sekali semasa load
            kategoriPengerusiSelect.addEventListener('change', kategoriPengerusi);
        }

        const penganjurSelect = document.getElementById("penganjur");
        if (penganjurSelect) {
            alert_nama_penganjur(); // Panggil sekali semasa load
            penganjurSelect.addEventListener('change', alert_nama_penganjur);
        }

        const sajianSelect = document.getElementById("jenis_sajian");
        if (sajianSelect) {
            sajianSelected(sajianSelect.value); // Panggil sekali semasa load
            sajianSelect.addEventListener('change', function () {
                sajianSelected(this.value);
            });
        }

        const webexYa = document.getElementById("ya");
        const webexTidak = document.getElementById("tidak");
        if (webexYa && webexTidak) {
            webexSelected(); // Panggil semasa load
            webexYa.addEventListener('change', webexSelected);
            webexTidak.addEventListener('change', webexSelected);
        }

        const vcCheckbox = document.getElementById("vc_selected");
        if (vcCheckbox) {
            showHideForm(); // Panggil semasa load
            vcCheckbox.addEventListener('change', showHideForm);
        }

        const CHECK_AVAILABILITY_URL = "{{ route('check.availability') }}";
        const CSRF_TOKEN = "{{ csrf_token() }}";

        //fungsi untuk elak banyak kali panggil fungsi checkAvailability
        let debounceTimeout;
        function debounceCheckAvailability(roomId, start, end, row) {
            clearTimeout(debounceTimeout); // Reset timeout jika user masih menaip/ubah
            debounceTimeout = setTimeout(() => {
                if (!start || !end) {
                    console.log('⛔ debounceCheckAvailability batal sebab input kosong');
                    const statusSpan = row.querySelector('.availability-status');
                    if (statusSpan) {
                        statusSpan.innerHTML = '';
                        statusSpan.removeAttribute('data-status');
                    }
                    return;
                }
                checkAvailability(roomId, start, end, row); // Jalankan sebenar selepas 300ms
            }, 300);
        }
    
        function checkAvailability(roomId, start, end, row) {
            console.log("5. checkAvailabilityIfReady...");
            const message = "Tarikh ini tidak tersedia.";
            if (!start || !end || !roomId) {
                // console.log('Tidak cukup data 2, checkAvailability tidak dipanggil');
                const statusSpan = row.querySelector('.availability-status');
                if (statusSpan) {
                    statusSpan.innerHTML = '';
                    statusSpan.removeAttribute('data-status');
                }
                return;
            }
            const statusSpan = row.querySelector('.availability-status');
            statusSpan.innerHTML = '<i class="fas fa-spinner fa-spin text-muted fa-sm" title="Menyemak..."></i>';

            fetch(CHECK_AVAILABILITY_URL, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": CSRF_TOKEN
                },
                body: JSON.stringify({ room_id: roomId, start, end })
            })
            .then(response => response.json())
            .then(data => {
                if (data.available) {
                     const message = `Bilik tersedia`;
                    statusSpan.innerHTML = `
                        <i class="fas fa-check-circle text-success fa-lg"></i><span style="font-size: 9px; color: green; margin-left: 4px;">${message}</span>`;
                    statusSpan.setAttribute("data-status", "available"); // ✅
                } 
                else if (data.unavailable_dates?.length) {
                    const formattedList = data.unavailable_dates.map(formatTarikhDMY).join('<br>');

                    const message = `Bilik tidak tersedia (xoo1)`;
                    statusSpan.innerHTML = `<i class="fas fa-exclamation-triangle text-danger fa-lg" title="${message}"></i><span style="font-size: 9px; color: red; margin-left: 4px;">${message}</span>`; 
                    statusSpan.setAttribute("data-status", "unavailable"); // ✅            
                } 
                else {
                    statusSpan.innerHTML = `
                        <i class="fas fa-exclamation-circle text-danger fa-lg"
                      ></i><span style="font-size: 9px; color: red;margin-left: 4px;">${message}</span>`;
                    statusSpan.setAttribute("data-status", "unavailable"); // ✅
                }
            });
        }

        initFlatpickrForRow(firstRow);
        bindChangeEventToRow(firstRow);
      
        document.getElementById('addRow').addEventListener('click', function () {
            const newRow = firstRow.cloneNode(true);

            newRow.querySelectorAll('input').forEach(input => {
                input.value = '';

                const name = input.getAttribute('name');
                if (name) input.setAttribute('name', name.replace(/\[\d+]/, `[${index}]`));

                input.removeAttribute('id');

                if (input._flatpickr) {
                    input._flatpickr.destroy(); // hapus Flatpickr instance dari hasil clone
                }

                input.removeAttribute('readonly'); // optional: elak gangguan clear manual
            });

            newRow.querySelector('.availability-status').textContent = '';
            newRow.querySelector('.remove-row').style.display = 'inline-block';

            bookingContainer.appendChild(newRow);

            initFlatpickrForRow(newRow);      // ✅ re-init Flatpickr pada baris baru
            bindChangeEventToRow(newRow);     // ✅ untuk fungsi checkAvailability dll.
            index++;
        });

        bookingContainer.addEventListener('click', function (e) {
            const btn = e.target.closest('.remove-row');
            if (btn && bookingContainer.querySelectorAll('.booking-row').length > 1) {
                btn.closest('.booking-row').remove();
            }
        });

        // ===================== SELECT2 & ROOM CHANGE ===================== //
        
        $('#room').on('select2:select change', function () {
            const selected = $(this).find('option:selected');

            const isAuto   = selected.data('auto');   // Y / N
            const isUpload = selected.data('upload'); // Y / N
            const isPantry = selected.data('pantry'); // Y / N

            // simpan dalam hidden input
            $('#is_auto').val(isAuto);
            $('#is_upload').val(isUpload);
            $('#is_pantry').val(isPantry);

            // 1. Handle tab bilik
            if (isAuto === 'N') {
                // disablekan tab bilik → letak class disabled
                $('#tab-bilik').addClass('disabled');

                // show alert manual
                $('#div_alert_bilik_manual').show();

                // kalau tab bilik sedang aktif → terus lompat ke VC
                if ($('#tab-bilik').hasClass('active')) {
                    $('#tab-vc').tab('show');
                }
            } else {
                $('#tab-bilik').removeClass('disabled');
                $('#div_alert_bilik_manual').hide();
            }

            // 2. Handle upload → show kalau isUpload == 'Y'
            if (isUpload === 'Y') {
                $('#div_upload').show();
            } else {
                $('#div_upload').hide();
            }

            // 3. Pantry → kalau ada extra action boleh letak sini

            // 4. Check availability untuk setiap row
            document.querySelectorAll('.booking-row').forEach(checkAvailabilityIfReady);
        }).trigger('change');

        // ===================== SUBMIT FORM ===================== //
        document.getElementById('applicationForm')?.addEventListener('submit', function (e) {
            removeDateError(e);
            markInvalidSequenceRows(); // 🚨 jalankan semula untuk pastikan validation terkini

            const sequenceError = document.querySelector('.availability-status[data-status="sequence-error"]');

            if (sequenceError) {
                e.preventDefault(); // ❌ halang submit jika masih salah

                // Ambil mesej dari ikon
                const msg = sequenceError.querySelector('i')?.getAttribute('title') || 'Susunan tarikh tidak sah';

                // ✅ Popup masa submit
                Swal.fire({
                title: 'Susunan Tarikh Tidak Sah',
                text: msg,
                icon: 'warning', // boleh buang kalau guna iconHtml
                iconHtml: '<i class="fas fa-exclamation-triangle fa-4x text-warning"></i>',
                customClass: {
                    icon: 'no-default-icon'
                },
                confirmButtonText: 'OK'
                });

                return;
            }

            document.getElementById('submitButton').disabled = true;
        });

        document.getElementById('copy_applicant')?.addEventListener('change', function () {
            const isChecked = this.checked;
            const data = {
                nama: "{{ $user->name }}",
                email: "{{ $user->email }}",
                jawatan: "{{ $user->profile->position_id }}",
                bahagian: "{{ $user->profile->department_id }}",
                sambungan: "{{ $user->profile->no_extension }}",
                bimbit: "{{ $user->profile->no_bimbit }}"
            };

            document.getElementById("nama_urusetia").value = isChecked ? data.nama : '';
            document.getElementById("email_urusetia").value = isChecked ? data.email : '';

            // Set value dan trigger change untuk select2
            $('#jawatan_urusetia').val(isChecked ? data.jawatan : '').trigger('change');
            $('#bahagian_urusetia').val(isChecked ? data.bahagian : '').trigger('change');

            document.getElementById("no_sambungan_urusetia").value = isChecked ? data.sambungan : '';
            document.getElementById("no_bimbit_urusetia").value = isChecked ? data.bimbit : '';
        });


    

    });

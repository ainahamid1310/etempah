<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use DateTime;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\RequiredIf;

class ApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     *

     */
    protected function prepareForValidation()
    {
        $bookings = $this->input('bookings', []);

        foreach ($bookings as $i => $booking) {
            if (isset($booking['start'])) {
                $bookings[$i]['start'] = $this->parseDate($booking['start']);
            }

            if (isset($booking['end'])) {
                $bookings[$i]['end'] = $this->parseDate($booking['end']);
            }
        }

        $this->merge(['bookings' => $bookings]);
    }

    private function parseDate($value)
    {
        try {
            return Carbon::createFromFormat('d/m/Y H:i', $value)->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return $value;
        }
    }

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [            
            'bookings.*.start' => ['required', 'date'], 
            'bookings.*.end'   => ['required', 'date'],
            'nama_mesyuarat' => 'required|max:255',
            'room' => 'required',
            'kategori_pengerusi' => 'required',
            'nama_pengerusi' => 'required_if:kategori_pengerusi,=,0',
            'bilangan_tempahan' => 'required|integer',            
            'nama_urusetia' => 'required_if:is_auto,Y',
            'email_urusetia' => 'required_if:is_auto,Y',
            'jawatan_urusetia' => 'required_if:is_auto,Y',
            'bahagian_urusetia' => 'required_if:is_auto,Y',
            'no_sambungan_urusetia' => 'required_if:is_auto,Y',
            'no_bimbit_urusetia' => 'required_if:is_auto,Y',
            'kategori_mesyuarat' => 'required_if:is_auto,Y',
            'penganjur' => 'required_if:is_auto,Y',
            'nama_penganjur' => 'required_if:penganjur,BERSAMA,LUAR',            
            'surat_emel' => 'required_if:is_upload,Y|file|mimetypes:application/pdf|max:1024',           
            'vc_selected' => 'required_if:is_auto,N,S',
            'akaun_webex' => 'required_if:vc_selected,1',
            'peralatan' => 'required_if:vc_selected,1',
            'nama_aplikasi' => 'required_if:akaun_webex,0',
            'perakuan' => 'required',

        ];

        
    }

   public function withValidator($validator)
{
    $validator->after(function ($validator) {
        $bookings = $this->input('bookings', []);

        foreach ($bookings as $index => $booking) {
            $startRaw = $booking['start'] ?? null;
            $endRaw = $booking['end'] ?? null;

            try {
                $start = \Carbon\Carbon::parse($startRaw);
            } catch (\Exception $e) {
                $validator->errors()->add("bookings.$index.start", 'Sila masukkan tarikh mula dalam format sah (cth: 14/07/2025 09:00).');
                continue;
            }

            try {
                $end = \Carbon\Carbon::parse($endRaw);
            } catch (\Exception $e) {
                $validator->errors()->add("bookings.$index.end", 'Sila masukkan tarikh tamat dalam format sah (cth: 14/07/2025 12:00).');
                continue;
            }

            // ✅ Validate tarikh mula tidak lampau
            if ($start->lt(now())) {
                $validator->errors()->add("bookings.$index.start", 'Tarikh mula mestilah hari ini atau akan datang.');
            }

            // ✅ Validate tamat selepas mula
            if ($end->lt($start)) {
                $validator->errors()->add("bookings.$index.end", 'Tarikh tamat mestilah selepas atau sama dengan tarikh mula.');
            }
        }
    });
}




    public function messages()
    {
        return [
            'room.required' => 'Nama Bilik/Lokasi diperlukan',
            // 'bookings.*.start.required' => 'Sila pilih tarikh mula.',
            // 'bookings.*.start.after_or_equal' => 'Tarikh mula mestilah hari ini atau selepas.',
            // 'bookings.*.end.required' => 'Sila pilih tarikh tamat.',
            // 'bookings.*.end.after_or_equal' => 'Tarikh tamat mestilah selepas tarikh mula.',        
            
           
            'bookings.*.start.required' => 'Sila pilih tarikh mula.',
            'bookings.*.start.date_format' => 'Format tarikh mula tidak sah. (Contoh: 14/07/2025 09:00)',
            'bookings.*.end.required' => 'Sila pilih tarikh tamat.',
            'bookings.*.end.date_format' => 'Format tarikh tamat tidak sah. (Contoh: 14/07/2025 12:00)',

            'nama_mesyuarat.required' => 'Nama Mesyuarat diperlukan',
	        'nama_mesyuarat.max' => 'Nama Mesyuarat tidak melebihi 255 aksara',            
            'kategori_pengerusi.required' => 'Kategori Pengerusi diperlukan',
            'nama_pengerusi.required_if' => 'Nama Pengerusi diperlukan',
            'bilangan_tempahan.required' => 'Bil.Tempahan/Kehadiran diperlukan',
            'bilangan_tempahan.integer' => 'Bil.Tempahan/Kehadiran mestilah integer',
            'nama_urusetia.required_if' => 'Nama Urusetia diperlukan',
            'email_urusetia.required_if' => 'E-mel Urusetia diperlukan',
            'email_urusetia.email' => 'E-mel tidak sah',
            'jawatan_urusetia.required_if' => 'Jawatan Urusetia diperlukan',
            //Room
            'bahagian_urusetia.required_if' => 'Bahagian Urusetia diperlukan',
            'no_sambungan_urusetia.required_if' => 'No. Sambungan Urusetia diperlukan',
            'no_bimbit_urusetia.required_if' => 'No. Telefon Bimbit Urusetia diperlukan',
            'kategori_mesyuarat.required_if' => 'Kategori Mesyuarat diperlukan',
            'penganjur.required_if' => 'Penganjur diperlukan',
            'nama_penganjur.required_if' => 'Nama Penganjur diperlukan',
            'surat_emel.required_if' => 'Surat/E-mel Program diperlukan',           
            'surat_emel.mimes' => 'Setiap lampiran mesti dalam format PDF.',
            'surat_emel.max'   => 'Setiap lampiran mestilah kurang 1MB.',
            // 'sajian.required_if' => 'Sajian diperlukan',
            //VC
            'vc_selected.required_if' => 'Permohonan VC diperlukan',
            'akaun_webex.required_if' => 'Akaun WEBEX diperlukan',
            'peralatan.required_if' => 'Maklumat Peralatan diperlukan',
            // 'webex.required' => 'Akaun WEBEX diperlukan',
            'nama_aplikasi.required_if' => 'Nama Aplikasi diperlukan',
            'perakuan.required' => 'Perakuan perlulah dipilih sebelum menghantar permohonan',


        ];
    }
}

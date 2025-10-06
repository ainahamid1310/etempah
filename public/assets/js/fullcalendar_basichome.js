/* ------------------------------------------------------------------------------
 *
 *  # Fullcalendar basic options
 *
 *  Demo JS code for extra_fullcalendar_views.html and extra_fullcalendar_styling.html pages
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------


var FullCalendarBasic = function() {

    //
    // Setup module components
    //

    // Basic calendar
    var _componentFullCalendarBasic = function() {
        if (typeof FullCalendar == 'undefined') {
            console.warn('Warning - Fullcalendar files are not loaded.');
            return;
        }


        // Add demo events
        // ------------------------------

        // Default events
        //var events = [];


        // Initialization
        // ------------------------------

        //
        // Basic view
        //

        // Define element
        var calendarBasicViewElement = document.querySelector('.fullcalendar-basic');



        // Initialize
        if(calendarBasicViewElement) {
            const params = new URLSearchParams(window.location.search);
            var val = params.get('val');

            var calendarBasicViewInit = new FullCalendar.Calendar(calendarBasicViewElement, {
                plugins: [ 'dayGrid', 'interaction' ],
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                },
                defaultDate: new Date(),
                editable: false,
                eventLimit: true,
                displayEventTime : true,
                selectable: true,
                selectHelper: false,

                events: {
            url: '/events/show',
            //color: generateRandomColor(),
            //  textColor: '#000000',

          },
           dateClick: function(date, events, start, jsEvent, view) {
                // $('#modalTitle').html(start);
                // $('#modalBody').html(events.description);
                // $('#eventUrl').attr('href',events.url);
                // $('#calendarModal').modal();
                // alert('Clicked on: ' + date.format());
                // alert("Selected Date:"+date._d);

                //console.log(date.dateStr);
                window.location.href = "events/"+ date.dateStr+"/"+val;



                },




           failure: function() {
                alert('there was an error while fetching events!');
            },

        //   eventClick: function(events, jsEvent, view) {
            // $('#modalTitle').html(events.title);
            // $('#modalBody').html(events.description);
            // $('#eventUrl').attr('href',events.url);
            // $('#calendarModal').modal();
            //    var eventObj = info.event;
             //alert('Clicked on: ' + date.format());

//             var id = $(this).data('id');
//              $.ajax({
//           url: '/home/events/'+encodeURI(id),
//           type: "POST",
//           cache: false,

//           success: function(data) {
// //codes...
// }
// });
//                $('#createEventModal').modal();
            //     alert('Clicked Event Id = ' + eventObj.id);
    //         if (info.event.url) {
    //     window.open(info.event.url);
    //     info.jsEvent.preventDefault();
    //}


    //  if (settings.sameWindow) {
    //   window.open(calEvent.url, '_self');
    // }
    // $.ajax({
    //       url: getFormActionUrl,

    //   });
    // },


            }).render();
        }




        //
        // Agenda view
        //

        // Define element
        var calendarAgendaViewElement = document.querySelector('.fullcalendar-agenda');

        // Initialize
        if(calendarAgendaViewElement) {
            var calendarAgendaViewInit = new FullCalendar.Calendar(calendarAgendaViewElement, {
                plugins: [ 'dayGrid', 'timeGrid', 'interaction' ],
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                defaultDate: '2021-11-12',
                defaultView: 'timeGridWeek',
                editable: true,
                businessHours: true,
                events: events
            }).render();
        }


        //
        // List view
        //

        // Define element
        var calendarListViewElement = document.querySelector('.fullcalendar-list');

        // Initialize
        if(calendarListViewElement) {
            var calendarListViewInit = new FullCalendar.Calendar(calendarListViewElement, {
                plugins: [ 'list', 'interaction' ],
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'listDay,listWeek,listMonth'
                },
                views: {
                    listDay: { buttonText: 'Day' },
                    listWeek: { buttonText: 'Week' },
                    listMonth: { buttonText: 'Month' }
                },
                defaultView: 'listMonth',
                defaultDate: '2021-11-12',
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                events: events
            }).render();
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentFullCalendarBasic();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    FullCalendarBasic.init();
});

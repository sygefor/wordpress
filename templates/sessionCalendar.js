/**
 * Add somes days to a date or return date in differents formats
 * @param type
 * @param numberDays
 * @param format
 * @returns {string}
 */
function getDate(type, numberDays, format) {
    if (type === "end") {
        var date = new Date(event.end);
    }
    else {
        var date = new Date(event.start);
    }
    if (typeof numberDays !== "undefined" && numberDays > 0) {
        date.setDate(date.getDate() + numberDays);
    }

    var day = date.getDate();
    var month = date.getMonth();
    var year = date.getFullYear();

    month++;
    if (month < 10) {
        month = '0' + month;
    }
    if (day < 10) {
        day = '0' + day;
    }

    if (format === "fr") {
        return day + "/" + month + "/" + year;
    }
    return year + "-" + month + "-" + day + 'T00:00:00';
}

/**
 * Get Sygefor3 sessions and transform them to be compatible with fullcalendar
 * @param sessions
 * @returns {Array}
 */
function getEventsFromSession(sessions) {
    var events = [];
    for (var key in sessions['items']) {
        event = {};
        event.id = sessions['items'][key]['id'];
        event.trainingId = sessions['items'][key]['training']['id'];
        event.title = sessions['items'][key]['training']['name'];
        event.start = sessions['items'][key]['dateBegin'];
        event.dateBegin = getDate("start", 0, "fr");
        event.theme = sessions['items'][key]['training']['theme'];
        event.description = sessions['items'][key]['training']['program'];
        event.allDay = true;
        if (typeof sessions['items'][key]['dateEnd'] !== "undefined") {
            event.end = sessions['items'][key]['dateEnd'];
            event.dateEnd = getDate("end", 0, "fr");
            // fullcalendar need date end is day + 1 at 00h00 to display event till this date end
            if (event.start !== event.end) {
                event.end = getDate("end", 1);
            }
        }
        event.url = trainingLink + "?stage=" + sessions['items'][key]['training']['id'] + "&theme=" + theme;
        events.push(event);
    }
    return events;
}

jQuery(document).ready(function() {
    // qtip params
    var tooltip = jQuery('<div/>').qtip({
        prerender: true,
        id: 'fullcalendar',
        content: {
            text: ''
        },
        adjust: {
            resize: true
        },
        position: {
            my: 'bottom center',
            at: 'top left',
            target: 'event',
            viewport: jQuery('#fullcalendar')
        },
        style: 'qtip-light'
    }).qtip('api');

    // transform div calendar in fullcalendar
    jQuery('#calendar').fullCalendar({
        header: {
            left: 'prev,next,today',
            right: 'title'
        },
        // show session description tooltip
        eventMouseover: function(data, event, view) {
            var content = '' +
                '<p style="line-height: 17px;">' +
                '<strong>'+data.title+'</strong><br /><br />' +
                '<strong>Thématique :</strong> ' + data.theme + '<br /><br />' +
                (data.end && 'Du ' + data.dateBegin + ' au ' + data.dateEnd + '<br /><br />' || '' +
                'Le ' + data.dateBegin + '<br /><br />') +
                '</p>';

            tooltip.set({
                'content.text': content
            }).show(event);
        },
        eventMouseout: function() {tooltip.hide()},
        lang: 'fr',
        minTime: '08:00:00',
        maxTime: '18:00:00',
        weekends: false,
        timezone: 'Europe/Paris',
        events: getEventsFromSession(sessions)
    });
});
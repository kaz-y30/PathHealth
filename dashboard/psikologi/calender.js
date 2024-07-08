$(document).ready(function() {
    var calendar = $('#calendar').fullCalendar({
        editable: true,
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: 'date.php?psychologist_id=' + psychologist_id,
        selectable: true,
        selectHelper: true,
        select: function(start, end, allDay) {
            var notes = prompt("Masukkan nama kegiatan");
            if (notes) {
                var scheduled_date = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");

                $.ajax({
                    url: "save.php",
                    type: "POST",
                    data: {
                        psychologist_id: psychologist_id,
                        notes: notes,
                        scheduled_date: scheduled_date
                    },
                    success: function() {
                        calendar.fullCalendar('refetchEvents');
                        alert('Simpan Sukses');
                    },
                    error: function() {
                        alert('Gagal menyimpan data');
                    }
                });
            }
        },
        eventDrop: function(event) {
            var scheduled_date = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
            var consultation_id = event.id;
            var notes = event.title;
            var status = event.status;

            $.ajax({
                url: "edit.php",
                type: "POST",
                data: {
                    consultation_id: consultation_id,
                    psychologist_id: psychologist_id,
                    notes: notes,
                    scheduled_date: scheduled_date,
                    status: status
                },
                success: function() {
                    calendar.fullCalendar('refetchEvents');
                    alert('Jadwal Berubah');
                },
                error: function() {
                    alert('Gagal menyimpan data');
                }
            });
        }
    });
});

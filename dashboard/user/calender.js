$(document).ready(function() {
    var calendar = $('#calendar').fullCalendar({
        editable: true,
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: 'date.php?user_id=' + user_id,
        selectable: true,
        selectHelper: true,
        select: function(start, end, allDay) {
            var notes = prompt("Masukkan nama kegiatan");
            if (notes) {
                var scheduled_date = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");

                $.ajax({
                    url: 'save.php',
                    type: "POST",
                    data: {
                        user_id: user_id,
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
                url: 'edit.php',
                type: "POST",
                data: {
                    consultation_id: consultation_id,
                    user_id: user_id,
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
        },
        eventClick: function(event) {
            if (confirm("Apakah Anda yakin ingin menghapus jadwal ini?")) {
                var consultation_id = event.id;

                $.ajax({
                    url: 'delete.php',
                    type: "POST",
                    data: {
                        consultation_id: consultation_id
                    },
                    success: function() {
                        calendar.fullCalendar('refetchEvents');
                        alert('Jadwal Berhasil Dihapus');
                    },
                    error: function() {
                        alert('Gagal menghapus data');
                    }
                });
            }
        }
    });
});

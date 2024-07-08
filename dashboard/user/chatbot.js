$(document).ready(function() {
    $('#chatForm').on('submit', function(event) {
        event.preventDefault();
        var message = $('#message').val(); // Simpan pertanyaan pengguna sebelum dikirim

        // Ganti nama pengguna dengan nama lengkap dari pengguna yang sedang login
        var fullName = document.getElementById("chatbox").dataset.fullName;

        // Tambahkan pesan ke kotak obrolan dengan nama lengkap
        $('#chatbox').append('<p><strong>' + fullName + ':</strong> ' + message + '</p>');

        $.ajax({
            url: 'chatbotResponse.php',
            method: 'POST',
            data: { message: message },
            success: function(response) {
                // Ganti nama chatbot menjadi "Chatbot PSI" di dalam kotak obrolan
                var chatbotName = 'Chatbot PSI';
                // Tambahkan elemen baru untuk mengetik efek
                var newElement = $('<p><strong>' + chatbotName + ':</strong> <span class="typing"></span></p>');
                $('#chatbox').append(newElement);
                typeEffect(response, newElement.find('.typing'));
            }
        });

        // Hapus pertanyaan pengguna dari input
        $('#message').val('');
    });

    function typeEffect(text, target) {
        var i = 0;
        var speed = 100; // Kecepatan mengetik dalam milidetik

        function typeWriter() {
            if (i < text.length) {
                target.append(text.charAt(i));
                i++;
                setTimeout(typeWriter, speed);
            }
        }
        typeWriter();
    }
});

    <?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $to = $_POST['to'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $file = $_FILES['file'];

        $mail = new PHPMailer(true);

        try {
            // Mailtrap configuration
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = 'b80bca97c07819';
            $mail->Password = '0105ba680cc8ab';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            // Email settings
            $mail->setFrom('your_email@example.com', 'Your Name');
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->Body = $message;

            // Attach file if provided
            if ($file['size'] > 0) {
                $mail->addAttachment($file['tmp_name'], $file['name']);
            }

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contact Form</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <div class="min-h-screen bg-gray-100 flex items-center justify-center">
            <form id="contactForm" action="" method="POST" class="bg-white p-6 rounded-lg shadow-md w-full max-w-lg" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="to" class="block text-gray-700 font-bold mb-2">To:</label>
                    <input type="email" id="to" name="to" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="subject" class="block text-gray-700 font-bold mb-2">Subject:</label>
                    <input type="text" id="subject" name="subject" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="message" class="block text-gray-700 font-bold mb-2">Message:</label>
                    <textarea id="message" name="message" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="file" class="block text-gray-700 font-bold mb-2">Attach File:</label>
                    <input type="file" id="file" name="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Send</button>
                </div>
            </form>
        </div>

        <script>
            document.getElementById('contactForm').addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default form submission

                Swal.fire({
                    title: 'Sending...',
                    text: 'Please wait while we send your message.',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                var form = event.target;
                var formData = new FormData(form);

                fetch(form.action, {
                    method: form.method,
                    body: formData
                }).then(response => {
                    Swal.close();
                    return response.text();
                }).then(text => {
                    Swal.fire({
                        title: 'Success!',
                        text: "Your message has been sent successfully.",
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location = 'level-2.php';
                    });
                }).catch(error => {
                    Swal.close();
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an error sending your message.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
            });
        </script>
    </body>
    </html>


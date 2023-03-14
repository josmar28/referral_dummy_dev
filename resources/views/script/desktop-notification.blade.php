<script>
    function desktopNotification(title,body){
        if (Notification.permission !== "granted"){
            console.log('Get Permission');
            Notification.requestPermission();
        }

        else {
            var notification = new Notification(title, {
                icon: "{{ url('resources/img/dohro12logo2.png') }}",
                body: body,
            });

            notification.onclick = function () {
                window.open("{{ url('/') }}");
            };
        }
    }

</script>
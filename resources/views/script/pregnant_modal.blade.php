<script> 
    $('.lmp_date').change(function() {
        var date = $(this).val();
        var newdate = new Date(date);

        var cur_mon = newdate.getMonth()+1;

        if(cur_mon == 1 || cur_mon == 2 || cur_mon == 3)
        {
        newdate.setDate(newdate.getDate() + 7);
        newdate.setMonth(newdate.getMonth() + 9)
        newdate.setFullYear(newdate.getFullYear())
        }
        else
        {
        newdate.setDate(newdate.getDate() + 7);
        newdate.setMonth(newdate.getMonth() -3)
        newdate.setFullYear(newdate.getFullYear() + 1)
        }

        var now = new Date(newdate);
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);

        var edc_edd = now.getFullYear()+"-"+(month)+"-"+(day) ;

        $('#edc_edd').val(edc_edd);
        $('#edc_edd').change();

        var months = dateRange($(this).val(), edc_edd)

        var d = new Date(),

        n = d.getMonth() + 1,

        y = d.getFullYear();

        
    for(var i = 1; i <= months.length; i++) {
            if(n == months[0] || n == months[1] || n == months[2] || n == months[3])
            {
                $(".new_trimester").val('1st');
            }
            else if(n == months[4] || n == months[5] || n == months[6])
            {
                $(".new_trimester").val('2nd');
            }
            else if(n == months[7] || n == months[8] || n == months[9])
            {
                $(".new_trimester").val('3nd');
            }
        }


        var start = new Date($(this).val() ),
        end   = new Date($('.new_date_of_visit').val()),
        diff  = new Date(end - start),
        days  = diff/1000/60/60/24;
        weeks = days / 7;

        n = weeks.toFixed(1);
        whole = Math.floor(n);      // 1
        fraction = n - whole; // .25

        if(weeks.toFixed(1) > 1)
        {
            var gcd = function(a, b) {
            if (b < 0.0000001) return a;                // Since there is a limited precision we need to limit the value.

            return gcd(b, Math.floor(a % b));           // Discard any fractions due to limitations in precision.
            };

            var fraction = fraction.toFixed(1);
            var len = fraction.toString().length - 2;

            var denominator = Math.pow(10, len);
            var numerator = fraction * denominator;

            var divisor = gcd(numerator, denominator);    // Should be 5

            numerator /= divisor;                         // Should be 687
            denominator /= divisor;                       // Should be 2000

            // alert(Math.floor(numerator) + '/' + Math.floor(denominator));


            $('.new_aog').val( whole+ ' '+ Math.floor(numerator) + '/' + Math.floor(denominator)+ " " + "weeks");
            $('.new_aog').change();
        }
        else
        {
            var gcd = function(a, b) {
            if (b < 0.0000001) return a;                // Since there is a limited precision we need to limit the value.

            return gcd(b, Math.floor(a % b));           // Discard any fractions due to limitations in precision.
            };

            var fraction = fraction.toFixed(1);
            var len = fraction.toString().length - 2;

            var denominator = Math.pow(10, len);
            var numerator = fraction * denominator;

            var divisor = gcd(numerator, denominator);    // Should be 5

            numerator /= divisor;                         // Should be 687
            denominator /= divisor;                       // Should be 2000

            // alert(Math.floor(numerator) + '/' + Math.floor(denominator));

            $('.new_aog').val(whole+ ' '+ Math.floor(numerator) + '/' + Math.floor(denominator)+ " " + "week");
            $('.new_aog').change();
        }

    });

    function NumberBreakdown($number, $returnUnsigned = false)
    {
        $negative = 1;
        if ($number < 0)
        {
            $negative = -1;
            $number *= -1;
        }

        if ($returnUnsigned){
            return array(
                Math.floor($number),
            ($number - floor($number))
            );
        }

        return array(
            Math.floor($number) * $negative,
            ($number - floor($number)) * $negative
        );
    }

    function dateRange(startDate, endDate) {
        var start      = startDate.split('-');
        var end        = endDate.split('-');
        var startYear  = parseInt(start[0]);
        var endYear    = parseInt(end[0]);
        var dates      = [];

    for(var i = startYear; i <= endYear; i++) {
        var endMonth = i != endYear ? 11 : parseInt(end[1]) - 1;
        var startMon = i === startYear ? parseInt(start[1])-1 : 0;
        for(var j = startMon; j <= endMonth; j = j > 12 ? j % 12 || 11 : j+1) {
        var month = j+1;
        // var displayMonth = month < 10 ? '0'+month : month;
        // dates.push([i, displayMonth, '01'].join('-'));
        var displayMonth = month < 10 ? month : month;
        dates.push(displayMonth);
        }
    }
    return dates;
    }

    $('.new_date_of_visit').change(function() {
        var start = new Date($('.lmp_date').val()),
        end   = new Date($(this).val()),
        diff  = new Date(end - start),
        days  = diff/1000/60/60/24;
        weeks = days / 7;
        if(weeks.toFixed(1) > 1)
        {
            $('.new_aog').val(weeks.toFixed(1)+ " " + "weeks");
            $('.new_aog').change();
        }
        else
        {
            $('.new_aog').val(weeks.toFixed(1)+ " " + "week");
            $('.new_aog').change();
        }
    });




</script>
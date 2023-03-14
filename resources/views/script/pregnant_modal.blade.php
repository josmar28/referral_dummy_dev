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
        if(weeks.toFixed(1) > 1)
        {
            $('.new_aog').val(weeks.toFixed(1)+ " " + "weeks");
            $('.new_aog').change();
        }
        else{
            $('.new_aog').val(weeks.toFixed(1)+ " " + "week");
            $('.new_aog').change();
        }

    });

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
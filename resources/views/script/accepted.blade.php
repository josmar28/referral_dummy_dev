<script>
    $(document).ready(function(){
    
    var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
       removeItemButton: true,
       maxItemCount:10,
       searchResultLimit:10,
       renderChoiceLimit:10,
     }); 
    
    
    });

    <?php $user = Session::get('auth'); ?>

    var arriveRef = dbRef.ref('Arrival');
    var admitRef = dbRef.ref('Admit');
    var dischargetRef = dbRef.ref('Discharge');
    var transferRef = dbRef.ref('Transfer');
    var referred_name = '';
    //initializes variables
    var current_facility, code, patient_name, track_id, form_type,unique_id;
    current_facility = "{{ \App\Facility::find($user->facility_id)->name }}";

    $('body').on('click','.btn-action',function(){
        code = $(this).data('code');
        patient_name = $(this).data('patient_name');
        track_id = $(this).data('track_id');
        unique_id = $(this).data('unique_id');
    });
    
    $('body').on('click','.patient_return',function(){
    var patient_id = $(this).data('patient_id');
    var unique_id = $(this).data('unique_id');
    var code = $(this).data('code');
        console.log(code)
        $.ajax({
            url: "{{ url('doctor/patient/info/') }}/"+patient_id,
            type: "GET",
            success: function(data){
                var sign = data.sign;
               
                var data = data.data;
                patient_id = data.id;
                name = data.patient_name;
                sex = data.sex;
                age = data.age;
                civil_status = data.civil_status;
                phic_status = data.phic_status;
                phic_id = data.phic_id;
                address = data.address;
                contact = data.contact;
                dob = data.dob;

                $('.patient_id').val(patient_id);
                $('.unique_id').val(unique_id);
                $('.code').val(code);

                var now = new Date();

                var day = ("0" + now.getDate()).slice(-2);
                var month = ("0" + (now.getMonth() + 1)).slice(-2);

                var new_date_of_visit = now.getFullYear()+"-"+(month)+"-"+(day) ;

                $('.new_date_of_visit').val(new_date_of_visit);

            
                //preg_prev
                if(sign)
                {
                    $(".prev_trimester").val(sign.no_trimester);
                    $(".prev_visit").val(sign.no_visit);
                
                        
                    var tri_no = sign.no_trimester.slice(0,-2);

                    var new_tri_no = ++tri_no;
                    var val2 ='';

                        var a = new_tri_no % 10,
                        b = new_tri_no % 100;

                        if (a == 1 && b != 11) {
                            val2 = new_tri_no + "st";
                        } else if (a == 2 && b != 12) {
                            val2 = new_tri_no + "nd";
                        } else if (a == 3 && b != 13) {
                            val2 = new_tri_no + "rd";
                        } else {
                            val2 = new_tri_no + "th";
                        }

                        $(".new_trimester").val(val2);
                    
                

                    var visit_no = sign.no_visit.slice(0,-2);

                    var new_visit_no = ++visit_no;
                    var val ='';

                        var a = new_visit_no % 10,
                        b = new_visit_no % 100;

                        if (a == 1 && b != 11) {
                            val = new_visit_no + "st";
                        } else if (a == 2 && b != 12) {
                            val = new_visit_no + "nd";
                        } else if (a == 3 && b != 13) {
                            val = new_visit_no + "rd";
                        } else {
                            val = new_visit_no + "th";
                        }

                    $(".new_visit_no").val(val);
                    
                
                    $('.prev_date').val(sign.date_of_visit);

                    $('.prev_subjective').val(sign.subjective); 

                    $('.prev_aog').val(sign.aog);

                    $('.prev_bp').val(sign.bp);
                    $('.prev_hr').val(sign.hr);
                    $('.prev_fh').val(sign.fh);

                    $('.prev_temp').val(sign.temp);
                    $('.prev_rr').val(sign.rr);
                    $('.prev_fht').val(sign.fht);

                    $('.prev_other_exam').val(sign.other_physical_exam);
                    $('.prev_assestment_diagnosis').val(sign.assessment_diagnosis);
                    $('.prev_plan_intervention').val(sign.plan_intervention);

                    if(sign.vaginal_spotting == 'yes')
                    {
                        $('.prev_viganal_bleeding').prop('checked', true);
                    }

                    if(sign.severe_nausea == 'yes')
                    {
                        $('.prev_severe_nausea').prop('checked', true);
                    }

                    if(sign.significant_decline == 'yes')
                    {
                        $('.prev_significant_decline').prop('checked', true);
                    }

                    if(sign.premature_rupture == 'yes')
                    {
                        $('.prev_premature_rupture').prop('checked', true);
                    }

                    if(sign.fetal_pregnancy == 'yes')
                    {
                        $('.prev_multi_pregnancy').prop('checked', true);
                    }

                    if(sign.severe_headache == 'yes')
                    {
                        $('.prev_persistent_severe').prop('checked', true);
                    }

                    if(sign.abdominal_pain == 'yes')
                    {
                        $('.prev_abdominal_pain').prop('checked', true);
                    }

                    if(sign.edema_hands == 'yes')
                    {
                        $('.prev_edema_hands').prop('checked', true);
                    }

                    if(sign.fever_pallor == 'yes')
                    {
                        $('.prev_fever_pallor').prop('checked', true);
                    }

                    if(sign.seizure_consciousness == 'yes')
                    {
                        $('.prev_seiszure_consciousness').prop('checked', true);
                    }

                    if(sign.difficulty_breathing == 'yes')
                    {
                        $('.prev_difficulty_breathing').prop('checked', true);
                    }

                    if(sign.painful_urination == 'yes')
                    {
                        $('.prev_painful_urination').prop('checked', true);
                    }

                    if(sign.elevated_bp == 'yes')
                    {
                        $('.prev_elevated_bp').prop('checked', true);
                    }
                }
                else{
                        val = "1" + "st";
                        $(".new_visit_no").val(val);
                    }
                
                    if( $( ".new_visit_no" ).val() == "1st" )
                    {
                        $(".bp_personnal").keyup(function(){
                            $(".bp_antepartum").val(this.value);
                        });

                        $(".temp_personnal").keyup(function(){
                            $(".temp_antepartum").val(this.value);
                        });

                        $(".hr_personnal").keyup(function(){
                            $(".hr_antepartum").val(this.value);
                        });

                        $(".rr_personnal").keyup(function(){
                            $(".rr_antepartum").val(this.value);
                        });

                        $(".fh_personnal").keyup(function(){
                            $(".fh_antepartum").val(this.value);
                        });
                    //3rd tab
                        $(".bp_personnal").keyup(function(){
                            $(".bp_signsymptoms").val(this.value);
                        });

                        $(".temp_personnal").keyup(function(){
                            $(".temp_signsymptoms").val(this.value);
                        });

                        $(".hr_personnal").keyup(function(){
                            $(".hr_signsymptoms").val(this.value);
                        });

                        $(".rr_personnal").keyup(function(){
                            $(".rr_signsymptoms").val(this.value);
                        });

                        $(".fh_personnal").keyup(function(){
                            $(".fh_signsymptoms").val(this.value);
                        });
                    }
                    else
                    {
                        $(".bp_personnal").unbind("keyup");
                        $(".temp_personnal").unbind("keyup");
                        $(".hr_personnal").unbind("keyup");
                        $(".rr_personnal").unbind("keyup");
                        $(".fh_personnal").unbind("keyup");
                    }
            
            },
            error: function(){
                $('#serverModal').modal();
            }
        });

    });


    $('#deadForm').on('submit',function(e){
        $('.loading').show();
         e.preventDefault();
         var remarks = $(this).find('.remarks').val();
        $(this).ajaxSubmit({
            url: "{{ url('doctor/referral/dead/') }}/" + track_id,
            type: 'POST',
            success: function(date){
                var dead_data = {
                    code: code,
                    patient_name: patient_name,
                    track_id: track_id,
                    date: date,
                    current_facility: current_facility,
                    remarks: remarks
                };
                $('.activity_'+code).html('DEAD ON ARRIVAL');
                arriveRef.push(dead_data);
                arriveRef.on('child_added',function(data){
                    setTimeout(function(){
                        arriveRef.child(data.key).remove();
                        var msg = 'Patient is dead on arrival';
                        $('.info').removeClass('hide').find('.message').html(msg);
                        $('#DoAModal').modal('hide');
                        window.location.reload(true);
                    },500);
                });
            },
            error: function(){
                $('#serverModal').modal();
            }
        });
    });

    $('#arriveForm').on('submit',function(e){
        $('.loading').show();
         e.preventDefault();
         var remarks = $(this).find('.remarks').val();
        $(this).ajaxSubmit({
            url: "{{ url('doctor/referral/arrive/') }}/" + track_id,
            type: 'POST',
            success: function(date){
                var arrive_data = {
                    code: code,
                    patient_name: patient_name,
                    track_id: track_id,
                    date: date,
                    current_facility: current_facility,
                    remarks: remarks
                };
                $('.activity_'+code).html('ARRIVED');
                arriveRef.push(arrive_data);
                arriveRef.on('child_added',function(data){
                    setTimeout(function(){
                        arriveRef.child(data.key).remove();
                        var msg = 'Patient arrived to your facility';
                        $('.info').removeClass('hide').find('.message').html(msg);
                        $('#arriveModal').modal('hide');
                        window.location.reload(true);
                    },500);
                });
            },
            error: function(){
                $('#serverModal').modal();
            }
        });
    });

    $('#archiveForm').on('submit',function(e){
        $('.loading').show();
         e.preventDefault();
         var remarks = $(this).find('.remarks').val();
        $(this).ajaxSubmit({
            url: "{{ url('doctor/referral/archive/') }}/" + track_id,
            type: 'POST',
            success: function(date){
                var arrive_data = {
                    code: code,
                    patient_name: patient_name,
                    track_id: track_id,
                    date: date,
                    current_facility: current_facility,
                    remarks: remarks
                };
                $('.activity_'+code).html('ARCHIVED');
                arriveRef.push(arrive_data);
                arriveRef.on('child_added',function(data){
                    setTimeout(function(){
                        arriveRef.child(data.key).remove();
                        var msg = 'Patient archived';
                        $('.info').removeClass('hide').find('.message').html(msg);
                        $('#arriveModal').modal('hide');
                        window.location.reload(true);
                    },500);
                });
            },
            error: function(){
                $('#serverModal').modal();
            }
        });
    });


    $('#MonOPDForm').on('submit',function(e){
        $('.loading').show();
        e.preventDefault();
        $(this).ajaxSubmit({
            url: "{{ url('doctor/referral/monitored/opd') }}/" + track_id,
            type: 'POST',
            success: function(date){
                $('.activity_'+code).html('MONITORED AS OPD');
                var arrive_data = {
                    code: code,
                    patient_name: patient_name,
                    track_id: track_id,
                    date: date,
                    current_facility: current_facility
                };
                    monitorRef.push(arrive_data);
                    monitorRef.on('child_added',function(data){
                    setTimeout(function(){
                        monitorRef.child(data.key).remove();
                        var msg = 'Patient monitored as OPD to your facility';
                        $('.info').removeClass('hide').find('.message').html(msg);
                        $('#admitModal').modal('hide');
                        window.location.reload(true);
                    },500);
                });
            },
            error: function(){
                $('#serverModal').modal();
            }
        });
    });

    $('#admitForm').on('submit',function(e){
        $('.loading').show();
        e.preventDefault();
        $(this).ajaxSubmit({
            url: "{{ url('doctor/referral/admit/') }}/" + track_id,
            type: 'POST',
            success: function(date){
                $('.activity_'+code).html('ADMITTED');
                var arrive_data = {
                    code: code,
                    patient_name: patient_name,
                    track_id: track_id,
                    date: date,
                    current_facility: current_facility
                };
                admitRef.push(arrive_data);
                admitRef.on('child_added',function(data){
                    setTimeout(function(){
                        admitRef.child(data.key).remove();
                        var msg = 'Patient admitted to your facility';
                        $('.info').removeClass('hide').find('.message').html(msg);
                        $('#admitModal').modal('hide');
                        window.location.reload(true);
                    },500);
                });
            },
            error: function(){
                $('#serverModal').modal();
            }
        });
    });


    $('#dischargeForm2').on('submit',function(e){
        $('.loading').show();
        e.preventDefault();
        var remarks = $(this).find('.remarks').val();
        $(this).ajaxSubmit({
            url: "{{ url('doctor/referral/discharge/') }}/" + track_id + "/" + unique_id,
            type: 'POST',
            success: function(date){
                var msg = 'Patient admitted to your facility';
                $('.info').removeClass('hide').find('.message').html(msg);
                $('.activity_'+code).html('DISCHARGED');
                var arrive_data = {
                    code: code,
                    patient_name: patient_name,
                    track_id: track_id,
                    date: date,
                    current_facility: current_facility,
                    remarks: remarks
                };
                dischargetRef.push(arrive_data);
                dischargetRef.on('child_added',function(data){
                    setTimeout(function(){
                        dischargetRef.child(data.key).remove();
                        window.location.reload(false);
                    },500);
                });
            },
            error: function(){
                $('#serverModal').modal();
            }
        });
    });



    $('#dischargeForm').on('submit',function(e){
        $('.loading').show();
        e.preventDefault();
        var remarks = $(this).find('.remarks').val();
        $(this).ajaxSubmit({
            url: "{{ url('doctor/referral/discharge/') }}/" + track_id,
            type: 'POST',
            success: function(date){
                var msg = 'Patient admitted to your facility';
                $('.info').removeClass('hide').find('.message').html(msg);
                $('.activity_'+code).html('DISCHARGED');
                var arrive_data = {
                    code: code,
                    patient_name: patient_name,
                    track_id: track_id,
                    date: date,
                    current_facility: current_facility,
                    remarks: remarks
                };
                dischargetRef.push(arrive_data);
                dischargetRef.on('child_added',function(data){
                    setTimeout(function(){
                        dischargetRef.child(data.key).remove();
                        window.location.reload(false);
                    },500);
                });
            },
            error: function(){
                $('#serverModal').modal();
            }
        });
    });



    $('body').on('click','.btn-transfer',function(){
        $('.loading').hide();
    });

    $('.select_facility').on('change',function(){
        var id = $(this).val();
        var url = "{{ url('location/facility/') }}";
        $.ajax({
            url: url+'/'+id,
            type: 'GET',
            success: function(data){
                console.log(data);
                $('.facility_address').html(data.address);

                $('.select_department').empty()
                    .append($('<option>', {
                        value: '',
                        text : 'Select Department...'
                    }));
                jQuery.each(data.departments, function(i,val){
                    $('.select_department').append($('<option>', {
                        value: val.id,
                        text : val.description
                    }));
                });
            },
            error: function(){
                $('#serverModal').modal();
            }
        });

    });

    $('body').on('submit','#referAcceptForm',function(e){
        $('.loading').show();
        e.preventDefault();
        referred_to = $('#referAcceptForm').find('.new_facility').val();
        var new_facility = $('#referAcceptForm').find('.new_facility').find(':selected').html();
        var referred_to = $('#referAcceptForm').find('.new_facility').val();
        var department_name = $('.select_department_accept :selected').text();
        var department_id = $('.select_department_accept').val();
        var reason = $('#referAcceptForm').find('.reject_reason').val();
        $(this).ajaxSubmit({
            url: "{{ url('doctor/referral/transfer/') }}/"+track_id,
            type: 'POST',
            success: function(data){
                console.log(data);
                transferRef.push({
                    date: data.date,
                    item: track_id,
                    new_facility: new_facility,
                    old_facility: current_facility,
                    action_md: data.action_md,
                    patient_name: patient_name,
                    code: code,
                    reason: reason,
                    activity_id: data.activity_id
                });

                transferRef.on('child_added',function(d){
                    setTimeout(function(){
                        transferRef.child(d.key).remove();
                    },500);
                });

                var connRef = dbRef.ref('Referral');
                var refer_data = {
                    referring_name: current_facility,
                    patient_code: code,
                    name: patient_name,
                    age: data.age,
                    sex: data.sex,
                    date: data.date,
                    form_type: data.form_type,
                    tracking_id: data.track_id,
                    referring_md: data.action_md,
                    referred_from: data.referred_facility,
                    department_id: department_id,
                    department_name: department_name,
                    activity_id: data.activity_id
                };
                console.log(refer_data);
                connRef.child(referred_to).push(refer_data);

                connRef.on('child_added',function(data){
                    setTimeout(function(){
                        connRef.child(data.key).remove();
                        window.location.reload(false);
                    },500);
                });

                var data = {
                    "to": "/topics/ReferralSystem"+referred_to,
                    "data": {
                        "subject": "New Referral",
                        "date": data.date,
                        "body": patient_name+" was transferred to your facility from "+current_facility+"!"
                    }
                };
                $.ajax({
                    url: 'https://fcm.googleapis.com/fcm/send',
                    type: 'post',
                    data: JSON.stringify(data),
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'key=AAAAJjRh3xQ:APA91bFJ3YMPNZZkuGMZq8MU8IKCMwF2PpuwmQHnUi84y9bKiozphvLFiWXa5I8T-lP4aHVup0Ch83PIxx8XwdkUZnyY-LutEUGvzk2mu_YWPar8PmPXYlftZnsJCazvpma3y5BI7QHP'
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.info(data);
                    }
                });
            },
            error: function(){
                $('#serverModal').modal();
            }
        });
    });



    function getNormalForm()
    {
        console.log("{{ url('doctor/referral/data/normal') }}/"+id);
        $.ajax({
            url: "{{ url('doctor/referral/data/normal') }}/"+id,
            type: "GET",
            success: function(data){
                var print_url = "{{ url('doctor/print/form/') }}/"+id;
                $('.btn-refer-normal').attr('href',print_url);

                patient_name = data.patient_name;
                referring_name = data.referring_name;

                var address='';
                var patient_address='';
                var referred_address = '';


                address += (data.facility_brgy) ? data.facility_brgy+', ': '';
                address += (data.facility_muncity) ? data.facility_muncity+', ': '';
                address += (data.facility_province) ? data.facility_province: '';

                referred_address += (data.ff_brgy) ? data.ff_brgy+', ': '';
                referred_address += (data.ff_muncity) ? data.ff_muncity+', ': '';
                referred_address += (data.ff_province) ? data.ff_province: '';

                patient_address += (data.patient_brgy) ? data.patient_brgy+', ': '';
                patient_address += (data.patient_muncity) ? data.patient_muncity+', ': '';
                patient_address += (data.patient_province) ? data.patient_province: '';

                var case_summary = data.case_summary;
                if (/\n/g.test(case_summary))
                {
                    case_summary = case_summary.replace(/\n/g, '<br>');
                }

                var reco_summary = data.reco_summary;
                if (/\n/g.test(reco_summary))
                {
                    reco_summary = reco_summary.replace(/\n/g, '<br>');
                }

                var diagnosis = data.diagnosis;
                if (/\n/g.test(diagnosis))
                {
                    diagnosis = diagnosis.replace(/\n/g, '<br>');
                }

                var reason = data.reason;
                if (/\n/g.test(reason))
                {
                    reason = reason.replace(/\n/g, '<br>');
                }


                age = data.age;
                sex = data.sex;
                referring_contact = data.referring_contact;
                referring_md_contact = data.referring_md_contact;
                referred_name = data.referring_name;

                $('span.referring_name').html(data.referring_name);
                $('span.department_name').html(data.department);
                $('span.referring_contact').html(data.referring_contact);
                $('span.referring_address').html(address);
                $('span.referred_name').html(data.referred_name);
                $('span.referred_address').html(referred_address);
                $('span.time_referred').html(data.time_referred);
                $('span.patient_name').html(data.patient_name);
                $('span.patient_age').html(data.age);
                $('span.patient_sex').html(data.sex);
                $('span.patient_status').html(data.civil_status);
                $('span.patient_address').html(patient_address);
                $('span.phic_status').html(data.phic_status);
                $('span.phic_id').html(data.phic_id);
                $('span.case_summary').append(case_summary);
                $('span.reco_summary').html(reco_summary);
                $('span.diagnosis').html(diagnosis);
                $('span.reason').html(reason);
                $('span.referring_md').html(data.md_referring);
                $('span.referring_md_contact').html(data.referring_md_contact);
                $('span.referred_md').html(data.md_referred);
                $('span.patient_bday').html(data.bday);

                $('span.covid_number').html(data.covid_number);
                $('span.clinical_status').html(data.refer_clinical_status);
                $('span.surveillance_category').html(data.refer_sur_category);

                $('.loading').hide();
            },
            error: function(){
                $('#serverModal').modal();
                $('.loading').hide();
            }
        });

    }

    function getPregnantForm()
    {
        $.ajax({
            url: "{{ url('doctor/referral/data/pregnant') }}/"+id,
            type: "GET",
            success: function(record){
                console.log(record);
                var print_url = "{{ url('doctor/print/form/') }}/"+id;
                $('.btn-refer-pregnant').attr('href',print_url);
                $('.button_option').hide();
                var data = record.form;
                var baby = record.baby;
                var patient_address='';
                var referred_address= '';
               


                patient_address += (data.patient_brgy) ? data.patient_brgy+', ': '';
                patient_address += (data.patient_muncity) ? data.patient_muncity+', ': '';
                patient_address += (data.patient_province) ? data.patient_province: '';

                referred_address += (data.ff_brgy) ? data.ff_brgy+', ': '';
                referred_address += (data.ff_muncity) ? data.ff_muncity+', ': '';
                referred_address += (data.ff_province) ? data.ff_province: '';

                var woman_major_findings = data.woman_major_findings;
                if (/\n/g.test(woman_major_findings))
                {
                    woman_major_findings = woman_major_findings.replace(/\n/g, '<br>');
                }

                var woman_information_given = data.woman_information_given;
                if (/\n/g.test(woman_information_given))
                {
                    woman_information_given = woman_information_given.replace(/\n/g, '<br>');
                }

                if(baby){
                    var baby_major_findings = baby.baby_major_findings;
                    if (/\n/g.test(baby_major_findings))
                    {
                        baby_major_findings = baby_major_findings.replace(/\n/g, '<br>');
                    }

                    var baby_information_given = baby.baby_information_given;
                    if (/\n/g.test(baby_information_given))
                    {
                        baby_information_given = baby_information_given.replace(/\n/g, '<br>');
                    }
                }

                age = data.woman_age;
                sex = data.sex;
                referring_contact = data.referring_contact;
                referring_md_contact = data.referring_md_contact;
                referred_name = data.referring_facility;

                $('span.record_no').html(data.record_no);
                $('span.arrival_date').html(data.arrival_date);
                $('span.referred_date').html(data.referred_date);
                $('span.md_referring').html(data.md_referring);
                $('span.referring_md_contact').html(data.referring_md_contact);
                $('span.referring_facility').html(data.referring_facility);
                $('span.department_name').html(data.department);
                $('span.referring_contact').html(data.referring_contact);
                $('span.referred_name').html(data.referred_facility);
                $('span.referred_address').html(referred_address);
                $('span.facility_brgy').html(data.facility_brgy);
                $('span.facility_muncity').html(data.facility_muncity);
                $('span.facility_province').html(data.facility_province);
                $('span.health_worker').html(data.health_worker);
                $('span.woman_name').html(data.woman_name);
                $('span.woman_age').html(data.woman_age);
                $('span.woman_bday').html(data.bday);
                $('span.woman_address').html(patient_address);
                $('span.woman_reason').html(data.woman_reason);
                $('span.woman_major_findings').html(woman_major_findings);
                $('span.woman_before_treatment').html(data.woman_before_treatment);
                $('span.woman_before_given_time').html(data.woman_before_given_time);
                $('span.woman_during_transport').html(data.woman_during_transport);
                $('span.woman_transport_given_time').html(data.woman_transport_given_time);
                $('span.woman_information_given').html(woman_information_given);

                if(baby){

                    $('span.baby_name').html(baby.baby_name);
                    $('span.baby_dob').html(baby.baby_dob);
                    $('span.weight').html(baby.weight);
                    $('span.gestational_age').html(baby.gestational_age);
                    $('span.baby_reason').html(baby.baby_reason);
                    $('span.baby_major_findings').html(baby_major_findings);
                    $('span.baby_last_feed').html(baby.baby_last_feed);
                    $('span.baby_before_treatment').html(baby.baby_before_treatment);
                    $('span.baby_before_given_time').html(baby.baby_before_given_time);
                    $('span.baby_during_transport').html(baby.baby_during_transport);
                    $('span.baby_transport_given_time').html(baby.baby_transport_given_time);
                    $('span.baby_information_given').html(baby_information_given);
                }

                $('span.covid_number').html(data.covid_number);
                $('span.clinical_status').html(data.refer_clinical_status);
                $('span.surveillance_category').html(data.refer_sur_category);

                $('.loading').hide();
            },
            error: function(){
                $('#serverModal').modal();
                $('.loading').hide();
            }
        });
    }

    
    $('.css_btn').on('click',function(){
       var code = $(this).data('code');
        var url = "<?php echo asset('doctor/css'); ?>";
        var json = {
            "code" : code,
            "_token" : "<?php echo csrf_token(); ?>"
        };
        $.post(url,json,function(result){
            $(".css_body").html(result);
        });
       
    });

    @if(Session::get('cssAdd'))
        Lobibox.notify('success', {
            title: "",
            msg: "Successfully Added CSS",
            size: 'mini',
            rounded: true
        });

    <?php
        Session::put("cssAdd",false);
    ?>
    @endif    

</script>
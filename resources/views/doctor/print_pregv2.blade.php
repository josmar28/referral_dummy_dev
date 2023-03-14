<?php
use App\Facility;
    $print_preg = Session::get('print_preg');
    $facility = Facility::find($print_preg['form']->referring_facility)->first();
    // dd($print_preg['form']->tracking_id);
    //dd($facility);
?>
<html><title>Print Details</title>
<style>
    .upper td, .info td, .table td {
        border:1px solid #000;
    }
    body {
        font-size: 12px;
    }
</style>
<body>
    <table class="info" >
        <tr class="bg-gray">
            <th colspan="5">A. Personnal Data</th>
        </tr>
        <tr>
            <td>Referring Facility: <span class="text-primary">{{ $facility->name }} </span></td>
            <td>Address of facility: <span class="text-primary"> {{ $facility->address }} </td>
            <td >PHIC: <span class="text-primary phic_id"></span> </td>
            <td>Referred Date: <span class="text-primary"></span> </td>
        </tr>
         <tr>
            <td >Name of Patient: <span class="text-primary patient_name">{{ $print_preg['form']->woman_name }}</span> </td>
            <td>Age: <span class="text-primary patient_age"></span> </td>
            <td>Sex: <span class="text-primary preg_patient_sex"></span> </td>
            <td>
                 Educational Attainment:
                <span class="text-primary preg_patient_sex"></span>
            </td>
        </tr>
        <tr>
            <td>Address of Patient: <span class="text-primary patient_address"></span>{{ $print_preg['form']->patient_brgy }} {{ $print_preg['form']->patient_muncity }} {{ $print_preg['form']->patient_province }} </td>
            <td>Birthday: <span class="text-primary patient_dob"></span></td>
            <td>Marital Status: <span class="text-primary preg_civil_status"></span> </td>
            <td>
                Family Monthly Income:
                <span class="text-primary preg_patient_sex"></span>
                </td>
        </tr>
        <tr>
            <td>Contact No. of Patient: <span class="text-primary patient_contact"></span>{{ $print_preg['form']->contact }}</td>
            <td>Religion:  <span class="text-primary preg_patient_sex"></span> </td>
            <td>Ethnicity:  <span class="text-primary preg_patient_sex"></span> </td>
            <td>Sibling Rank: <span class="text-primary preg_patient_sex"></span> Out of  
            <span class="text-primary preg_patient_sex"></span>
            </td>
        </tr>
    </table>

    <table class="info" >
        <tr class="bg-gray">
            <th colspan="5">B. Antepartum Conditions (Medical/Obstetrical History)</th>
        </tr>
        <tr>
            <td>Referring Facility: <span class="text-primary"> </td>
            <td>Address of facility: <span class="text-primary"></span> </td>
            <td >PHIC: <span class="text-primary phic_id"></span> </td>
            <td>Referred Date: <span class="text-primary"></span> </td>
        </tr>
         <tr>
            <td >Name of Patient: <span class="text-primary patient_name"></span> </td>
            <td>Age: <span class="text-primary patient_age"></span> </td>
            <td>Sex: <span class="text-primary preg_patient_sex"></span> </td>
            <td>
                 Educational Attainment:
                <span class="text-primary preg_patient_sex"></span>
            </td>
        </tr>
        <tr>
            <td>Address of Patient: <span class="text-primary patient_address"></span> </td>
            <td>Birthday: <span class="text-primary patient_dob"></span></td>
            <td>Marital Status: <span class="text-primary preg_civil_status"></span> </td>
            <td>
                Family Monthly Income:
                <span class="text-primary preg_patient_sex"></span>
                </td>
        </tr>
        <tr>
            <td>Contact No. of Patient: <span class="text-primary patient_contact"></span> </td>
            <td>Religion:  <span class="text-primary preg_patient_sex"></span> </td>
            <td>Ethnicity:  <span class="text-primary preg_patient_sex"></span> </td>
            <td>Sibling Rank: <span class="text-primary preg_patient_sex"></span> Out of  
            <span class="text-primary preg_patient_sex"></span>
            </td>
        </tr>
    </table>

    <table class="info" >
        <tr class="bg-gray">
            <th colspan="5">C. Laboratory Results</th>
        </tr>
        <tr>
            <td>Referring Facility: <span class="text-primary"> </td>
            <td>Address of facility: <span class="text-primary"></span> </td>
            <td >PHIC: <span class="text-primary phic_id"></span> </td>
            <td>Referred Date: <span class="text-primary"></span> </td>
        </tr>
         <tr>
            <td >Name of Patient: <span class="text-primary patient_name"></span> </td>
            <td>Age: <span class="text-primary patient_age"></span> </td>
            <td>Sex: <span class="text-primary preg_patient_sex"></span> </td>
            <td>
                 Educational Attainment:
                <span class="text-primary preg_patient_sex"></span>
            </td>
        </tr>
        <tr>
            <td>Address of Patient: <span class="text-primary patient_address"></span> </td>
            <td>Birthday: <span class="text-primary patient_dob"></span></td>
            <td>Marital Status: <span class="text-primary preg_civil_status"></span> </td>
            <td>
                Family Monthly Income:
                <span class="text-primary preg_patient_sex"></span>
                </td>
        </tr>
        <tr>
            <td>Contact No. of Patient: <span class="text-primary patient_contact"></span> </td>
            <td>Religion:  <span class="text-primary preg_patient_sex"></span> </td>
            <td>Ethnicity:  <span class="text-primary preg_patient_sex"></span> </td>
            <td>Sibling Rank: <span class="text-primary preg_patient_sex"></span> Out of  
            <span class="text-primary preg_patient_sex"></span>
            </td>
        </tr>
    </table>

    <table class="info" >
        <tr class="bg-gray">
            <th colspan="5">D. Warning Signs and Symptoms of Pregnancy</th>
        </tr>
        <tr>
            <td>Referring Facility: <span class="text-primary"> </td>
            <td>Address of facility: <span class="text-primary"></span> </td>
            <td >PHIC: <span class="text-primary phic_id"></span> </td>
            <td>Referred Date: <span class="text-primary"></span> </td>
        </tr>
         <tr>
            <td >Name of Patient: <span class="text-primary patient_name"></span> </td>
            <td>Age: <span class="text-primary patient_age"></span> </td>
            <td>Sex: <span class="text-primary preg_patient_sex"></span> </td>
            <td>
                 Educational Attainment:
                <span class="text-primary preg_patient_sex"></span>
            </td>
        </tr>
        <tr>
            <td>Address of Patient: <span class="text-primary patient_address"></span> </td>
            <td>Birthday: <span class="text-primary patient_dob"></span></td>
            <td>Marital Status: <span class="text-primary preg_civil_status"></span> </td>
            <td>
                Family Monthly Income:
                <span class="text-primary preg_patient_sex"></span>
                </td>
        </tr>
        <tr>
            <td>Contact No. of Patient: <span class="text-primary patient_contact"></span> </td>
            <td>Religion:  <span class="text-primary preg_patient_sex"></span> </td>
            <td>Ethnicity:  <span class="text-primary preg_patient_sex"></span> </td>
            <td>Sibling Rank: <span class="text-primary preg_patient_sex"></span> Out of  
            <span class="text-primary preg_patient_sex"></span>
            </td>
        </tr>
    </table>

</body>
</html>
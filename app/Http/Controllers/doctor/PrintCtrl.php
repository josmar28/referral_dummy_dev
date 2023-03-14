<?php

namespace App\Http\Controllers\doctor;

use Anouar\Fpdf\Fpdf;
use App\Tracking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\doctor\ReferralCtrl;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class PrintCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //this->middleware('doctor');
    }

    public function printReferral($track_id)
    {
        $data = array();
        $user = Session::get('auth');
        $form_type = Tracking::where('id',$track_id)
            ->first();
        if($form_type){
            $form_type = $form_type->type;
        }else{
            return redirect('doctor');
        }

        if($form_type=='normal')
        {
            $data = ReferralCtrl::normalForm($track_id);
            return self::printNormal($data);
        }else if($form_type=='pregnant'){
            // $data = ReferralCtrl::pregnantForm($track_id);
            // return self::printPregnant($data); 
            
            $data = ReferralCtrl::pregnantFormv2($track_id);
            Session::put('print_preg',$data);
            return self::printPregnantv2($data);
        }
    }

    public function printPregnantv2($record)
    {
       
        $display = view("doctor.print_pregv2");
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($display);
        return $pdf->stream();
    }

    public function printPregnant($record)
    {

        $data = $record['form'];
        $baby = $record['baby'];
        //print_r($baby);
        $pdf = new Fpdf();
        $x = ($pdf->w)-20;

        $patient_address='';
        $referred_address= '';

        $patient_address .= ($data->patient_brgy) ? $data->patient_brgy.', ': '';
        $patient_address .= ($data->patient_muncity) ? $data->patient_muncity.', ': '';
        $patient_address .= ($data->patient_province) ? $data->patient_province: '';

        $referred_address .= ($data->ff_brgy) ? $data->ff_brgy.', ': '';
        $referred_address .= ($data->ff_muncity) ? $data->ff_muncity.', ': '';
        $referred_address .= ($data->ff_province) ? $data->ff_province: '';

        $pdf->setTopMargin(17);
        $pdf->setTitle($data->woman_name);
        $pdf->addPage();

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(0,0,"Republic of the Philippines",0,"","C");
       
        $pdf->ln();
        $pdf->Cell(0,10,"Department of Health",0,"","C");
        $pdf->ln();
        $pdf->Cell(0,0,"Center of Health Development",0,"","C");
        $pdf->ln();
        $pdf->Cell(0,10,"SOCCSKSARGEN Region",0,"","C");
        $pdf->ln();
        $pdf->Cell(0,5,"Clinical Referral Form",0,"","C");
        $pdf->Ln(5);
        $pdf->SetFont('Arial','',10);
        $pdf->MultiCell(0, 7, self::black($pdf,"Patient Code: ").self::orange($pdf,$data->code,"Patient Code :"), 0, 'L');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','',10);
        $pdf->MultiCell(0, 7, self::black($pdf,"REFERRAL RECORD"), 0, 'L');
        $pdf->SetFont('Arial','',10);

        $pdf->MultiCell($x/4, 7, self::black($pdf,"Who is Referring"), 0, 'L');
        $y = $pdf->getY();
        $pdf->SetXY(60, $y-7);
        $pdf->MultiCell($x/4, 7, self::black($pdf,"Record Number: ").self::orange($pdf,$data->record_no,"Record Number:"), 0);
        $y = $pdf->getY();
        $pdf->SetXY(125, $y-7);
        $pdf->MultiCell($x/2, 7, self::black($pdf,"Referred Date: ").self::orange($pdf,$data->referred_date,"Referred Date:"), 0);

        $pdf->MultiCell($x/2, 7, self::black($pdf,"Name of referring MD/HCW: ").self::orange($pdf,$data->md_referring,"Name of referring MD/HCW:"), 0, 'L');
        $y = $pdf->getY();
        $pdf->SetXY(125, $y-7);
        $pdf->MultiCell($x/2, 7, self::black($pdf,"Arrival Date: ").self::orange($pdf,$data->arrival_date,"Arrival Date:"), 0);

        $pdf->MultiCell(0, 7, self::black($pdf,"Contact # of referring MD/HCW: ").self::orange($pdf,$data->referring_md_contact,"Contact # of referring MD/HCW:"), 0, 'L');
        $pdf->MultiCell(0, 7, self::black($pdf,"Facility: ").self::orange($pdf,$data->referring_facility,"Facility:"), 0, 'L');
        $pdf->MultiCell(0, 7, self::black($pdf,"Facility Contact #: ").self::orange($pdf,$data->referring_contact,"Facility Contact #:"), 0, 'L');
        $pdf->MultiCell(0, 7, self::black($pdf,"Accompanied by the Health Worker: ").self::orange($pdf,$data->health_worker,"Accompanied by the Health Worker:"), 0, 'L');

        $pdf->MultiCell($x/2, 7, self::black($pdf,"Referred To: ").self::orange($pdf,$data->referred_facility,"Referred To:"), 0, 'L');
        $y = $pdf->getY();
        $pdf->SetXY($x/2+40, $y-7);
        $pdf->MultiCell($x/2, 7, self::black($pdf,"Department: ").self::orange($pdf,$data->department,"Department:"), 0);

        $pdf->MultiCell(0, 7, self::black($pdf,"Address: ").self::orange($pdf,$referred_address,"Address:"), 0, 'L');
        $pdf->MultiCell(0, 7, self::black($pdf,"Covid Number: ").self::orange($pdf,$data->covid_number,"Covid Number: "), 0, 'L');
        $pdf->MultiCell(0, 7, self::black($pdf,"Clinical Status: ").self::orange($pdf,$data->refer_clinical_status,"Clinical Status: "), 0, 'L');
        $pdf->MultiCell(0, 7, self::black($pdf,"Surveillance Category: ").self::orange($pdf,$data->refer_sur_category,"Surveillance Category: "), 0, 'L');
        $pdf->MultiCell(0, 7, self::black($pdf,"Discharge Clinical Status: ").self::orange($pdf,$data->dis_clinical_status,"Discharge Clinical Status: "), 0, 'L');
        $pdf->MultiCell(0, 7, self::black($pdf,"Discharge Surveillance Category: ").self::orange($pdf,$data->dis_sur_category,"Discharge Surveillance Category: "), 0, 'L');
        $pdf->Ln(3);

        $pdf->SetFillColor(200,200,200);
        $pdf->SetTextColor(30);
        $pdf->SetDrawColor(200);
        $pdf->SetLineWidth(.3);

        $pdf->MultiCell(0, 7, "WOMAN", 1, 'L',true);

        $pdf->SetFillColor(255,250,205);
        $pdf->SetTextColor(40);
        $pdf->SetDrawColor(230);
        $pdf->SetLineWidth(.3);

        $pdf->MultiCell(0, 7, "Name: " .self::green($pdf,$data->woman_name,'name'), 1, 'L');
        $pdf->MultiCell(0, 7, "Age: " .self::green($pdf,$data->woman_age,'Age'), 1, 'L');
        $pdf->MultiCell(0, 7, "Birthday: " .self::green($pdf,$data->bday,'Birthday'), 1, 'L');
        $pdf->MultiCell(0, 7, "Address: " .self::green($pdf,$patient_address,'Address'), 1, 'L');
        $pdf->MultiCell(0, 7, self::staticBlack($pdf,"Main Reason for Referral: ")."\n".self::staticGreen($pdf,$data->woman_reason), 1, 'L');
        $pdf->MultiCell(0, 7, self::staticBlack($pdf,"Major Findings (Clinica and BP,Temp,Lab) : ")."\n".self::staticGreen($pdf,$data->woman_major_findings), 1, 'L');

        $pdf->SetFillColor(200,200,200);
        $pdf->SetTextColor(30);
        $pdf->SetDrawColor(200);
        $pdf->SetLineWidth(.3);

        $pdf->MultiCell(0, 7, "Treatments Give Time", 1, 'L',true);

        $pdf->SetFillColor(255,250,205);
        $pdf->SetTextColor(40);
        $pdf->SetDrawColor(230);
        $pdf->SetLineWidth(.3);

        $pdf->MultiCell(0, 7, "Before Referral: " .self::green($pdf,$data->woman_before_treatment.'-'.$data->woman_before_given_time,'Before Referral'), 1, 'L');
        $pdf->MultiCell(0, 7, "During Transport: " .self::green($pdf,$data->woman_before_given_time.'-'.$data->woman_before_given_time,'During Transport'), 1, 'L');
        $pdf->MultiCell(0, 7, self::staticBlack($pdf,"Information Given to the Woman and Companion About the Reason for Referral : ")."\n".self::staticGreen($pdf,$data->woman_information_given), 1, 'L');

        if(count($baby)>0)
        {
            $pdf->Ln(8);

            $pdf->SetFillColor(200,200,200);
            $pdf->SetTextColor(30);
            $pdf->SetDrawColor(200);
            $pdf->SetLineWidth(.3);

            $pdf->MultiCell(0, 7, "BABY", 1, 'L',true);

            $pdf->SetFillColor(255,250,205);
            $pdf->SetTextColor(40);
            $pdf->SetDrawColor(230);
            $pdf->SetLineWidth(.3);

            $pdf->MultiCell(0, 7, "Name: " .self::green($pdf,$baby->baby_name,'name'), 1, 'L');
            $pdf->MultiCell(0, 7, "Date of Birth: " .self::green($pdf,$baby->baby_dob,"Date of Birth"), 1, 'L');
            $pdf->MultiCell(0, 7, "Body Weight: " .self::green($pdf,$baby->weight,'body weight'), 1, 'L');
            $pdf->MultiCell(0, 7, "Gestational Age: " .self::green($pdf,$baby->weight,'Gestational Age'), 1, 'L');
            $pdf->MultiCell(0, 7, self::staticBlack($pdf,"Main Reason for Referral: ")."\n".self::staticGreen($pdf,$baby->baby_reason), 1, 'L');
            $pdf->MultiCell(0, 7, self::staticBlack($pdf,"Major Findings (Clinica and BP,Temp,Lab) : ")."\n".self::staticGreen($pdf,$baby->baby_major_findings), 1, 'L');
            $pdf->MultiCell(0, 7, "Last (Breast) Feed (Time): " .self::green($pdf,$baby->baby_last_feed,"Last (Breast) Feed (Time)"), 1, 'L');

            $pdf->SetFillColor(200,200,200);
            $pdf->SetTextColor(30);
            $pdf->SetDrawColor(200);
            $pdf->SetLineWidth(.3);

            $pdf->MultiCell(0, 7, "Treatments Give Time", 1, 'L',true);

            $pdf->SetFillColor(255,250,205);
            $pdf->SetTextColor(40);
            $pdf->SetDrawColor(230);
            $pdf->SetLineWidth(.3);

            $pdf->MultiCell(0, 7, "Before Referral: " .self::green($pdf,$baby->baby_before_treatment.'-'.$baby->baby_before_given_time,'Before Referral'), 1, 'L');
            $pdf->MultiCell(0, 7, "During Transport: " .self::green($pdf,$baby->baby_during_transport.'-'.$baby->baby_transport_given_time,'During Transport'), 1, 'L');
            $pdf->MultiCell(0, 7, self::staticBlack($pdf,"Information Given to the Woman and Companion About the Reason for Referral : ")."\n".self::staticGreen($pdf,$baby->baby_information_given), 1, 'L');
        }
        $pdf->Output();
        exit();
    }

    public function printNormal($data)
    {
       //print_r($data);
        $address='';
        $patient_address='';
        $referred_address = '';

        $address .= ($data->facility_brgy) ? $data->facility_brgy .', ': '';
        $address .= ($data->facility_muncity) ? $data->facility_muncity .', ': '';
        $address .= ($data->facility_province) ? $data->facility_province: '';

        $referred_address .= ($data->ff_brgy) ? $data->ff_brgy .', ': '';
        $referred_address .= ($data->ff_muncity) ? $data->ff_muncity .', ': '';
        $referred_address .= ($data->ff_province) ? $data->ff_province: '';

        $patient_address .= ($data->patient_brgy) ? $data->patient_brgy.', ': '';
        $patient_address .= ($data->patient_muncity) ? $data->patient_muncity.', ': '';
        $patient_address .= ($data->patient_province) ? $data->patient_province: '';

        $pdf = new Fpdf();
        $x = ($pdf->w)-20;

        $image1 = "resources/img/doh.png";
        
        $image2 = "resources/img/f1.jpg";  
        

        $pdf->setTopMargin(17);
        $pdf->setTitle($data->patient_name);
        $pdf->addPage();

        $pdf->MultiCell($x/2, 7, $pdf->Image($image1, $pdf->GetX(), $pdf->GetY(), 20.78));
        $y = $pdf->getY();
        $pdf->SetXY($x/2+80, $y-7);
        $pdf->MultiCell($x/2, 4,  $pdf->Image($image2, $pdf->GetX(), $pdf->GetY(), 20.78));

 
        // $pdf->Cell( 0, 10, $pdf->Image($image1, $pdf->GetX(), $pdf->GetY(), 33.78) );
        // $pdf->Cell( 0, 10, $pdf->Image($image2, $pdf->GetX(), $pdf->GetY(), 10), 0, 0, 'L', false );
    
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(0,0,"Republic of the Philippines",0,"","C");
       
        $pdf->ln();
        $pdf->Cell(0,10,"Department of Health",0,"","C");
        $pdf->ln();
        $pdf->Cell(0,0,"Center of Health Development",0,"","C");
        $pdf->ln();
        $pdf->Cell(0,10,"SOCCSKSARGEN Region",0,"","C");
        $pdf->ln();
        $pdf->Cell(0,5,"Clinical Referral Form",0,"","C");
        $pdf->Ln(5);
        $pdf->SetFont('Arial','',10);
        $pdf->MultiCell(0, 7, self::black($pdf,"Patient Code: ").self::orange($pdf,$data->code,"Patient Code :"), 0, 'L');
        $pdf->Ln();
        // $pdf->MultiCell(0, 7, self::black($pdf,"Name of Referring Facility: ").self::orange($pdf,$data->referring_name,"Name of Referring Facility:"), 0, 'L');
        
        $pdf->MultiCell($x/2, 7, self::black($pdf,"Name of Referring Facility: ").self::orange($pdf,$data->referred_name,"Name of Referring Facility:"), 0, 'L');
        $y = $pdf->getY();
        $pdf->SetXY($x/2+10, $y-7);
        $pdf->MultiCell($x/2, 7, self::black($pdf,"License Number of Referring Facility: ").self::orange($pdf,$data->referring_license_no,"License Number of Referring Facility:"), 0);


        $pdf->MultiCell(0, 7, self::black($pdf,"Facility Contact #: ").self::orange($pdf,$data->referring_contact,"Facility Contact #:"), 0, 'L');
        $pdf->MultiCell(0, 7, self::black($pdf,"Address: ").self::orange($pdf,$address,"Address:"), 0, 'L');


        $pdf->MultiCell($x/2, 7, self::black($pdf,"Referred to: ").self::orange($pdf,$data->referred_name,"Referred to:"), 0, 'L');
        $y = $pdf->getY();
        $pdf->SetXY($x/2+10, $y-7);
        $pdf->MultiCell($x/2, 7, self::black($pdf,"Department: ").self::orange($pdf,$data->department,"Department:"), 0);

        $pdf->MultiCell(0, 7, self::black($pdf,"Address: ").self::orange($pdf,$referred_address,"Address:"), 0, 'L');

        $pdf->MultiCell($x/2, 7, self::black($pdf,"Date/Time Referred (ReCo): ").self::orange($pdf,$data->time_referred,"Date/Time Referred (ReCo):"), 0, 'L');
        $y = $pdf->getY();
        $pdf->SetXY($x/2+10, $y-7);
        $pdf->MultiCell($x/2, 7, self::black($pdf,"Date/Time Transferred: ").self::orange($pdf,$data->time_transferred,"Date/Time Transferred:"), 0);

        $pdf->MultiCell($x/2, 7, self::black($pdf,"Name of Patient: ").self::orange($pdf,$data->patient_name,"Name of Patient:"), 0, 'L');
        $y = $pdf->getY();
        $pdf->MultiCell($x/2, 7, self::black($pdf,"Birthday: ").self::orange($pdf,$data->bday,"Birthday:"), 0, 'L');
        $y = $pdf->getY();
        $pdf->SetXY($x/2+10, $y-7);
        $pdf->MultiCell($x/4, 7, self::black($pdf,"Age: ").self::orange($pdf,$data->age,"age:"), 0);
        $y = $pdf->getY();
        $pdf->SetXY(($x/2)+($x/4) - 15, $y-7);
        $pdf->MultiCell($x/4, 7, self::black($pdf,"Sex: ").self::orange($pdf,$data->sex,"sex:"), 0);
        $y = $pdf->getY();
        $pdf->SetXY(($x/2)+($x/2) - 30, $y-7);
        $pdf->MultiCell($x/4, 7, self::black($pdf,"Status: ").self::orange($pdf,$data->civil_status,"Status:"), 0);

        $pdf->MultiCell(0, 7, self::black($pdf,"Address: ").self::orange($pdf,$patient_address,"address:"), 0, 'L');

        $pdf->MultiCell($x/2, 7, self::black($pdf,"PhilHealth Status: ").self::orange($pdf,$data->phic_status,"PhilHealth status:"), 0, 'L');
        $y = $pdf->getY();
        $pdf->SetXY($x/2+10, $y-7);
        $pdf->MultiCell($x/2, 7, self::black($pdf,"PhilHealth # : ").self::orange($pdf,$data->phic_id,"PhilHealth # :"), 0);


        $pdf->MultiCell(0, 7, self::black($pdf,"Covid Number: ").self::orange($pdf,$data->covid_number,"Covid Number: "), 0, 'L');
        $pdf->MultiCell(0, 7, self::black($pdf,"Clinical Status: ").self::orange($pdf,$data->refer_clinical_status,"Clinical Status: "), 0, 'L');
        $pdf->MultiCell(0, 7, self::black($pdf,"Surveillance Category: ").self::orange($pdf,$data->refer_sur_category,"Surveillance Category: "), 0, 'L');
        $pdf->MultiCell(0, 7, self::black($pdf,"Discharge Clinical Status: ").self::orange($pdf,$data->dis_clinical_status,"Discharge Clinical Status: "), 0, 'L');
        $pdf->MultiCell(0, 7, self::black($pdf,"Discharge Surveillance Category: ").self::orange($pdf,$data->dis_sur_category,"Discharge Surveillance Category: "), 0, 'L');

        $pdf->MultiCell(0, 7, self::black($pdf,"Case Summary (pertinent Hx/PE, including meds, labs, course etc.): "), 0, 'L');
        $pdf->SetTextColor(102,56,0);
        $pdf->SetFont('Arial','I',10);
        $pdf->MultiCell(0, 5, $data->case_summary, 0, 'L');
        $pdf->Ln();

        $pdf->MultiCell(0, 7, self::black($pdf,"Summary of ReCo (pls. refer to ReCo Guide in Referring Patients Checklist): "), 0, 'L');
        $pdf->SetTextColor(102,56,0);
        $pdf->SetFont('Arial','I',10);
        $pdf->MultiCell(0, 5, $data->reco_summary, 0, 'L');
        $pdf->Ln();

        $pdf->MultiCell(0, 7, self::black($pdf,"Diagnosis/Impression: "), 0, 'L');
        $pdf->SetTextColor(102,56,0);
        $pdf->SetFont('Arial','I',10);
        $pdf->MultiCell(0, 5, $data->diagnosis, 0, 'L');
        $pdf->Ln();

        $pdf->MultiCell(0, 7, self::black($pdf,"Reason for referral: "), 0, 'L');
        $pdf->SetTextColor(102,56,0);
        $pdf->SetFont('Arial','I',10);
        $pdf->MultiCell(0, 5, $data->reason, 0, 'L');
        $pdf->Ln();

        $pdf->MultiCell($x/2, 7, self::black($pdf,"Name of referring MD/HCW: ").self::orange($pdf,$data->md_referring,"Name of referring MD/HCW:"), 0, 'L');
        $pdf->MultiCell($x/2, 7, self::black($pdf,"Contact # of referring MD/HCW: ").self::orange($pdf,$data->referring_md_contact,"Contact # of referring MD/HCW:"), 0, 'L');
        $pdf->MultiCell($x/2, 7, self::black($pdf,"Name of referred MD/HCW- Mobile Contact # (ReCo): ").self::orange($pdf,$data->md_referred,"Name of referred MD/HCW- Mobile Contact # (ReCo):"), 0, 'L');

        $pdf->Output();

        exit;
    }

    public function orange($pdf,$val,$str)
    {
        $y = $pdf->getY()+4.5;
        $x = $pdf->getX()+2;
        $ln = $pdf->GetStringWidth($str)+1;
        $pdf->SetTextColor(102,56,0);
        $pdf->SetFont('Arial','I',10);
        $r = $pdf->Text($x+$ln,$y,$val);
        $pdf->SetFont('Arial','',10);
        return $r;
    }

    public function staticGreen($pdf,$val)
    {
        $pdf->SetTextColor(0,50,0);
        $pdf->SetFont('Arial','',10);
        return $val;
    }

    public function staticBlack($pdf,$val)
    {
        $y = $pdf->getY()+4.5;
        $x = $pdf->getX()+2;
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','',10);
        return $pdf->Text($x,$y,$val);
    }

    public function green($pdf,$val,$str)
    {
        $y = $pdf->getY()+4.5;
        $x = $pdf->getX()+2;
        $ln = $pdf->GetStringWidth($str)+1;
        $pdf->SetTextColor(0,50,0);
        $pdf->SetFont('Arial','I',10);
        $r = $pdf->Text($x+$ln,$y,$val);
        $pdf->SetFont('Arial','',10);
        $pdf->SetTextColor(0,0,0);
        return $r;
    }

    public function gray($pdf,$val,$str)
    {
        $y = $pdf->getY()+4.5;
        $x = $pdf->getX()+2;
        $ln = $pdf->GetStringWidth($str)+1;
        $pdf->SetTextColor(51,51,51);
        $pdf->SetFont('Arial','I',10);
        $r = $pdf->Text($x+$ln,$y,$val);
        $pdf->SetFont('Arial','',10);
        return $r;
    }

    public function black($pdf,$val)
    {
        $y = $pdf->getY()+4.5;
        $x = $pdf->getX()+2;
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','B',10);
        return $pdf->Text($x,$y,$val);
    }
    
    public function patientConsent ()
    {
        $pdf = new Fpdf();
        $x = ($pdf->w)-20;

        $image1 = "resources/img/doh.png";
        
        $image2 = "resources/img/f1.jpg";  
        

        $pdf->setTopMargin(17);
        $pdf->setTitle($data->patient_name);
        $pdf->addPage();

        $pdf->MultiCell($x/2, 7, $pdf->Image($image1, $pdf->GetX(), $pdf->GetY(), 20.78));
        $y = $pdf->getY();
        $pdf->SetXY($x/2+80, $y-7);
        $pdf->MultiCell($x/2, 4,  $pdf->Image($image2, $pdf->GetX(), $pdf->GetY(), 20.78));

 
        // $pdf->Cell( 0, 10, $pdf->Image($image1, $pdf->GetX(), $pdf->GetY(), 33.78) );
        // $pdf->Cell( 0, 10, $pdf->Image($image2, $pdf->GetX(), $pdf->GetY(), 10), 0, 0, 'L', false );
    
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(0,0,"Republic of the Philippines",0,"","C");
       
        $pdf->ln();
        $pdf->Cell(0,10,"Department of Health",0,"","C");
        $pdf->ln();
        $pdf->Cell(0,0,"Center of Health Development",0,"","C");
        $pdf->ln();
        $pdf->Cell(0,10,"SOCCSKSARGEN Region",0,"","C");
        $pdf->ln();
        $pdf->Cell(0,5,"Patient Consent",0,"","C");
        $pdf->Ln(5);
        $pdf->SetFont('Arial','',10);
        $pdf->Ln();
        // $pdf->MultiCell(0, 7, self::black($pdf,"Name of Referring Facility: ").self::orange($pdf,$data->referring_name,"Name of Referring Facility:"), 0, 'L');
        
        $pdf->MultiCell(0, 7, self::black($pdf,"I, _______________________________________ hereby give my consent to send or transmit my health data or"), 0, 'L');
        $pdf->MultiCell(0, 7, self::black($pdf,"information to the Electronic Referral (E Referral) for the purpose of referring patients to other facilites"), 0, 'L');
        $pdf->MultiCell(0, 7, self::black($pdf,"and/or the Department of Healths (DOHs) National Health Data Reporting Requirements"), 0, 'L');
        $pdf->Ln();

        $pdf->MultiCell(0, 7, self::black($pdf,"As such, I was made to understand that:"), 0, 'L');
        $pdf->Ln();

        $pdf->Cell(0,7,"1. I am giving permission to Name of Facility and/or Health Care Provider who is involved in my care delivery",0,"","C");
        $pdf->ln();
        $pdf->Cell(0,7,"to gather and transmit pertinent health data or information to PhilHealth or DOH as applicable via",0,"","C");
        $pdf->ln();
        $pdf->Cell(0,7,"authorized and recognized data centers/ providers.",0,"","C");
        $pdf->Ln();
        $pdf->Ln();

        $pdf->Cell(0,7,"2. I understand that appropriate safety measures have been put in place to protect the privacy and security",0,"","C");
        $pdf->ln();
        $pdf->Cell(0,7,"of my well-being, health information, and other rights under laws governing data privacy and security, and",0,"","C");
        $pdf->ln();
        $pdf->Cell(0,7,"related issuances.",0,"","C");
        $pdf->Ln();
        $pdf->Ln();

        $pdf->Cell(0,7,"3. This consent is valid in PHIE Lite and other DOH National Health Data Reporting Requirements until it is",0,"","C");
        $pdf->ln();
        $pdf->Cell(0,7,"revoked by myself or my duly authorized representative.",0,"","C");
        $pdf->Ln();
        $pdf->Ln();

        $pdf->Cell(0,7,"4. I am made aware that I can cancel my consent at any time without giving reasons and without concerning",0,"","C");
        $pdf->ln();
        $pdf->Cell(0,7,"any disadvantage for my medical treatment and/or services.",0,"","C");
        $pdf->Ln();
        $pdf->Ln();

        $pdf->MultiCell(0, 7, self::black($pdf,"I certify that I have been made to understand my rights in a language and manner understandable to me by a"), 0, 'L');
        $pdf->MultiCell(0, 7, self::black($pdf,"representative of the facility/health care provider and that the health data or information is true and complete to the"), 0, 'L');
        $pdf->MultiCell(0, 7, self::black($pdf,"best of my knowledge."), 0, 'L');
        $pdf->Ln();

        $pdf->MultiCell(0, 7, self::black($pdf,"Signed this Date of Month, Year at Time."), 0, 'L');     
        $pdf->Ln();

        $pdf->MultiCell($x/2, 7, self::black($pdf,"_______________________________"), 0, 'L');
        $y = $pdf->getY();
        $pdf->SetXY($x/2+10, $y-7);
        $pdf->MultiCell($x/2, 7, self::black($pdf,"_______________________________"), 0);

        $pdf->MultiCell($x/2, 7, self::black($pdf,"Name of Patient/Representative"), 0, 'L');
        $y = $pdf->getY();
        $pdf->SetXY($x/2+10, $y-7);
        $pdf->MultiCell($x/2, 7, self::black($pdf,"Representative of Health Facility"), 0);

        $pdf->MultiCell($x/2, 7, self::black($pdf,"(Signature over printed name)"), 0, 'L');
        $y = $pdf->getY();
        $pdf->SetXY($x/2+10, $y-7);
        $pdf->MultiCell($x/2, 7, self::black($pdf,"(Signature over printed name)"), 0);
        $pdf->Ln();
        $pdf->MultiCell(0, 7, self::black($pdf,"Contact Number: _____________________"), 0, 'L');
        $pdf->Output();
        exit;
    }
}

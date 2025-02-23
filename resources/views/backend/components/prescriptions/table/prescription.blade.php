
<style>
   @media print {
    @page {
        size: A4 portrait; /* Set A4 size */
        margin: 5mm; /* Reduce margins */
    }

    body {
        margin: 0;
        padding: 0;
        zoom: 100%; /* Scale down content */
    }

    #print-prescription {
        width: 100%;
        height: auto;
        max-height: 280mm; /* Ensure it fits within A4 */
        overflow: hidden;
        transform: scale(0.95);
        transform-origin: top left;
        page-break-inside: avoid;
        page-break-before: avoid;
        page-break-after: avoid;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    td, th {
        padding: 2px;
        font-size: small;
        word-wrap: break-word;
        overflow-wrap: break-word;
        white-space: normal;
    }

    h3, h5 {
        margin: 0;
        font-size: smaller;
    }

    p, pre {
        font-size: small;
        white-space: normal;
    }

    tr, td {
        page-break-before: avoid;
        page-break-after: avoid;
        page-break-inside: avoid;
    }

    /* Make sure the prescription block does not break */
    #print-prescription * {
        max-height: 280mm; /* Fit within A4 */
    }
}
 
td, th, p {
    word-wrap: break-word;
    overflow-wrap: break-word;
}
pre, p {
    white-space: normal;
}
td {
    max-width: 300px; /* Adjust width based on your layout */
    overflow: hidden;
    text-overflow: ellipsis; /* Adds "..." if text is too long */
}



</style>

<div class="content-wrapper">
      <section class="content">
        <input class="mt-3 btn btn-success" type="button" onclick="printDiv('print-prescription')" value="Print" />
<div id="print-prescription" class="avoid-page-break">
    <table border="0" cellpadding="10" cellspacing="10" style="width: 100%">
        <tr style="border: solid 1px">
            <p>
                <h3 style="text-align: center;height: auto; margin-top: 0px">
                    بِسْمِ اللهِ الرَّحْمٰنِ الرَّحِيْمِ 
                </h3>
            </p>
            <td colspan="6" style="text-align: center; height: auto;"><h3>Your Hospatel Name</h3>
            <h5>Your Hospatel Address</h5>
            </td>
        </tr>
        
        <tr style="border: solid 0px">
            <td colspan="2" style="text-align: left;">
                @if ($doctor)
                    <h3 class="text-start mb-2 text-bold">
                        DR. {{ $doctor->first_name ?? '' }} {{ $doctor->middle_name ?? '' }} {{ $doctor->last_name ?? '' }}
                    </h3>
                    <p class="m-auto">{{ $doctor->degree ?? "No user data available" }}</p>
                    <p class="m-auto">{{ $doctor->speciality ?? "No user data available" }}</p>
                    <p class="m-auto">{{ $doctor->organization ?? "No user data available" }}</p>
                    <p class="m-auto">{{ $doctor->address_one ?? "No user data available" }}</p>
                @else
                    <h3 class="text-start mb-2 text-bold">No user data available</h3>
                @endif
            </td>
        </tr>
        
        <tr style="border: solid 1px ">
            <td style="padding: 2px; font-size: x-large;"><strong>{{$patient->title}} {{$patient->first_name}} {{$patient->middle_name}}  {{$patient->last_name}} </strong></td>
            <td></td><td></td>
            <td><strong>Age: {{$age}} </strong>Years</td>
            
            <td style="text-align: right; padding: 5px;" > <strong> Date:</strong> {{$formattedDate}} </td>
        </tr>
        <tr  valign="top">
      	            <td style="border: solid 1px; padding: 5px; width: 290px;">
                <table cellpadding="5" cellspacing="5">
                    
                      <tr>
                         <td>
                            <strong style="border-bottom: solid 1px;">PATIENT DETAILS</strong>
                            <p style="padding-top: 5px; font-size: larger; text-align: justify-all;">{{$patient->gender}},
                                {{$patient->phone_number}}, {{$patient->address_one}}</p>
                        </td>
                     </tr>

                        <tr>
                        <td>
                            <strong style="border-bottom: solid 1px;">D/D</strong>
                            <p style="padding-top: 10px; font-size: smaller; text-align: justify-all;">{{$advice->disease_description ?? "N/A"}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong style="border-bottom: solid 1px;">C/D</strong>
                            <p style="padding-top: 10px; font-size: smaller; text-align: justify-all;">{{$advice->clinical_diagnosis ?? "N/A"}}</p>
                        </td>
                    </tr>
										
                    <tr>
                        <td>
                            <strong style="border-bottom: solid 1px;">ADVICE</strong>
                            <p style="padding-top: 1px"><pre style="display: block;margin: 0 0 10px;font-size: smaller; text-align: justify-all; color: #333;background-color: #FFF;border: 0px;">{{$advice->advice ?? "N/A"}}</pre></p>
                        </td>
                    </tr>
					
					<tr>
                        <td>
                            <strong style="border-bottom: solid 1px;">INVESTIGATION</strong>
                            <p style="padding-top: 1px"><pre style="display: block;margin: 0 0 10px;font-size: smaller; text-align: justify-all; color: #333;background-color: #FFF;border: 0px;;">{{$advice->investigation ?? "N/A"}}</pre></p>
                        </td>
                    </tr>
					<tr>
                        <td>
                            <strong style="border-bottom: solid 1px;">GUIDE TO PREVIOUS PRESCRIPTION</strong>
                            <p style="padding-top: 1px;"><pre style="display: block;margin: 0 0 10px;font-size: smaller; text-align: justify-all; color: #333;background-color: #FFF;border: 0px;">{{$advice->guide_to_prescription ?? "N/A"}}</pre></p>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                </table>
            </td>
            <td style="border: solid 1px; padding: 10px" colspan="4">
                <P>
                    <span style="font-size: 25px; font-family: MingLiU_HKSCS-ExtB">M</span>t
                </p>
                <table cellpadding="5" cellspacing="5">
                    @foreach ($prescriptionData as $medicine )
                    <tr>
                        <td style="border-right: solid 1px; padding: 10px">{{ $loop->iteration }} .</td>
                        <td style="padding: 3px; font-size: medium;">
                            
                            <p>
                                <span style="font-size: 17px;">
                                    {{ $medicine->medicine_name }}
                                </span>
                            </p>
                            <p>
                               <span style="font-size: 13px;"> 
                                {{ $medicine->dose }} 
                        </span>
                        </p>
                        </td>
                        <td style="padding: 10px; width: 70px;text-align: right;">{{ $medicine->duration }}</td>
                        <td style="padding: 10px; width: 200px; text-align: justify-all;font-size: small;">{{ $medicine->duration_unit }}</td>
                       <!-- diet chart-->
                         <td style="padding: 10px; width: auto; text-align: justify;">{{ $medicine->instruction }}</td> 
                    </tr>
                    @endforeach
                </table>
            </td>
        </tr>
        <tr>
            <td style="text-align: left;padding-top: 5px">Next Meeting Date:{{$advice->next_meeting_date ?? "N/A"}}</td>
            <td colspan="0" style="text-align: center; padding-top: 5px">Powered By NPMS</td>
            <td style="text-align: right;padding-top: 5px" colspan="3">বিঃ দ্রঃ-পরবর্তী প্রয়োজনে ব্যবস্থাপত্র সংরক্ষণ করুন। </td>
                    </tr>
    </table>
</div>
      </section>
</div>


<script>
    function printDiv(divName) {
         var printContents = document.getElementById(divName).innerHTML;
         var originalContents = document.body.innerHTML;
    
         document.body.innerHTML = printContents;
    
         window.print();
    
         document.body.innerHTML = originalContents;
    }
</script>

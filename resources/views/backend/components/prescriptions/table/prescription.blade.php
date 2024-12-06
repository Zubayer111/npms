<style>
    .prescription-header h3 {
        font-size: 1.5rem;
        margin: 0;
    }

    .section-title {
        font-weight: bold;
        text-decoration: underline;
        margin-top: 20px;
    }

    .footer-note {
        font-size: 0.85rem;
    }

    .border-cell {
        border: 1px solid #ddd;
        padding: 10px;
    }
</style>


<div class="content-wrapper">
      <section class="content">
        <input class="btn btn-success mt-3" type="button" onclick="printDiv('print-prescription')" value="Print" />
        <div id="print-prescription" class="container my-4">
            <!-- Header Section -->
            <div class="row border mb-3 p-3">
                <div class="col-12 text-center">
                    <h3>بِسْمِ اللهِ الرَّحْمٰنِ الرَّحِيْمِ</h3>
                    <h3>Your Hospatel Name</h3>
                    <p>বিঃ দ্রঃ-পরবর্তী প্রয়োজনে ব্যবস্থাপত্র সংরক্ষণ করুন।</p>
                </div>
            </div>
    
            <div class="row">
                <!-- Doctor Info -->
                <div class="col-md-6">
                    @if($doctor)
                        <h3 class="text-start mb-2 text-bold">
                            DR. {{$doctor->first_name}} {{$doctor->middle_name}} {{$doctor->last_name}}
                        </h3>
                        <p class="m-auto">{{$doctor->degree ?? "No user data available"}}</p>
                        <p class="m-auto">{{$doctor->speciality ?? "No user data available"}}</p>
                        <p class="m-auto">{{$doctor->organization ?? "No user data available"}}</p>
                        <p class="m-auto">{{$doctor->address_one ?? "No user data available"}}</p>
                    @else
                        <p class="m-auto">No doctor data available</p>
                    @endif

                </div>
                <!-- Bengali Doctor Info -->
            </div>
    
            <!-- Patient Details -->
            <div class="row my-4 border p-3">
                <div class="col-md-6">
                    <p><strong>Patient Name:</strong> {{$patient->title}} {{$patient->first_name}} {{$patient->middle_name}}  {{$patient->last_name}}</p>
                    <p><strong>Age:</strong> {{$patient->age}}</p>
                    <p><strong>Gender:</strong> {{$patient->gender}}</p>
                    <p><strong>Address:</strong> {{$patient->address_one}}</p>
                    <p><strong>Phone:</strong> {{$patient->phone_number}}</p>
                </div>
                <div class="col-md-6 text-end">
                    <p><strong>Date:</strong> {{$formattedDate}}</p>
                </div>
            </div>
    
            <!-- Prescription and Advice -->
            <div class="row">
                <!-- Left Section -->
                <div class="col-md-4 border p-3">
                    <h5 class="section-title">Patient Details</h5>
                    <p>N/A</p>
                    <h5 class="section-title">D/D</h5>
                    <p>{{$advice->disease_description ?? "N/A"}}</p>
                    <h5 class="section-title">C/D</h5>
                    <p>{{$advice->clinical_diagnosis ?? "N/A"}}</p>
                    <h5 class="section-title">Advice</h5>
                    <p>{{$advice->advice ?? "N/A"}}</p>
                    <h5 class="section-title">Investigation</h5>
                    <p>{{$advice->investigation ?? "N/A"}}</p>
                    <h5 class="section-title">Guide to Previous Prescription</h5>
                    <p>{{$advice->guide_to_prescription ?? "N/A"}}</p>
                    <h5 class="section-title">Next Visit</h5>
                    <p>{{$advice->next_meeting_date ?? "N/A"}}</p>
                </div>
    
                <!-- Right Section -->
                <div class="col-md-8 border p-3">
                    <h5 class="section-title">Prescription</h5>
                        @foreach ($prescriptionData as $medicine )
                        <table cellpadding="5" cellspacing="5">
                            
                            <tr>
                                <td style="border-right: solid 1px; padding: 10px">{{ $loop->iteration }}</td>
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
                                <td style="padding: 10px; width: 70px;text-align: right;">{{ $medicine->duration }}
                                    </td><td style="padding: 10px; width: 70px;text-align: right;">{{ $medicine->duration_unit }}</td>
                                <td style="padding: 10px; width: 200px; text-align: justify-all;font-size: small;">{{ $medicine->instruction }}</td>
                            </tr>
                        </table>
                        @endforeach
                        
                    
                </div>
            </div>
    
            <!-- Footer -->
            <div class="row mt-4">
                <div class="col-md-6 footer-note">
                    <p><strong>Powered By</strong></p>
                    <p><strong>NPMS</strong></p>
                </div>
                <div class="col-md-6 text-end footer-note">
                    <p>বিঃ দ্রঃ-পরবর্তী প্রয়োজনে ব্যবস্থাপত্র সংরক্ষণ করুন।</p>
                </div>
            </div>
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

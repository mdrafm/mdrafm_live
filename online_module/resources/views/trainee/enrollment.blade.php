@extends('../layouts.app')
@section('content')
    <div class="pagetitle">
        <h1>Enrolled Programs</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Manage Program</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard min-vh-100 py-4">
        <div class="container">
            <!-- End Logo -->

            <div class="programs">


                @foreach ($programs as $program)
                    <div class="card mb-3">
                        <div class="card-header">
                            <h2>Enrollement Program Details </h2> <!-- Accessing the module relationship -->
                        </div>
                        <div class="card-body">
                            <p><strong>Module Name:</strong> {{ $program->module->module_name ?? 'N/A' }}</p>
                            <p><strong>Course Name:</strong> {{ $program->course->course_name ?? 'N/A' }}</p>
                            <!-- Accessing the course relationship -->
                            <p><strong>Duration:</strong> {{ $program->course->duration }} days</p>
                            <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($program->start_date)->format('d-m-y') }}</p>

                            <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($program->end_date)->format('d-m-y') }}</p>
                            <p><strong>Enrollment Start Date:</strong> {{ \Carbon\Carbon::parse($program->en_start_date)->format('d-m-y') }}</p>
                            <p><strong>Enrollment End Date:</strong> {{ \Carbon\Carbon::parse($program->en_end_date)->format('d-m-y') }}</p>


                            <hp>VC Dates</hp>
                            <ul>
                                @foreach ($program->programVcDates as $vcDate)
                                    <li>{{ $vcDate->description ?? 'N/A' }} :- {{ \Carbon\Carbon::parse($vcDate->vc_date)->format('d-m-y') ?? 'N/A' }}</li>
                                    <!-- Accessing programVcDates -->
                                @endforeach
                            </ul>
                            <p><strong>Panel Discussion Date & Time:</strong> {{ \Carbon\Carbon::parse($program->pd_date)->format('d-m-y h:i A') }}</p>
                            <p><strong>Exam Date & Time:</strong> {{ \Carbon\Carbon::parse($program->exam_date)->format('d-m-y h:i A') }}</p>
                            <div class="btn btn-info askRequestToenroll" data-program-id = {{ $program->id }} > Request To Enroll </div>
                        </div>
                    </div>
                @endforeach

            </div>


        </div>


    </section>
      <div class="modal fade" id="enrollModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Enroll Details</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-12 programWrap">

                          <p>1. Participants has to appear the practice tests for all subject.</p>
                          <p>2. After appearing the practice test of one subject, the trainee will be allowed to go the next subject</p>
                          <p>3. Two VCs have been arranged for the trainees to interact with different subject experts in which the trainee can ask their queries.</p>
                          <p>4. There will be a panel discussion date and time for clearing of doubts  before the final examination.</p>
                          <p>5. The final examination will be held at MDRAFM on the specified date.</p>
                          <p>6. After completing the examination and submitting feedback, participants can download their completion certificate</p>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                </div>
              </div>
            </div>
          </div>
@endsection

@section('script')
    $('.askRequestToenroll').on('click', function () {
        const program_id = $(this).attr('data-program-id');
        $('.modal-footer').html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-warning requestToEnroll" data-programId = ${program_id} data-bs-dismiss="modal">Enroll</button>
`)
      $('#enrollModal').modal('show')
    })

    $(document).on('click', '.requestToEnroll', function () {
        let programId = $(this).attr('data-programId');

        $.ajax({
            url: "{{ route('requestToEnroll') }}", // Your route to fetch courses
            type: 'POST',
            data: {
                program_id: programId
            },
            success: function(data) {
                console.log(data)

                if (data.error) {
                    alert(data.error);
                } else {
                    alert(data.message);
                   window.location.href = "{{route('get.enrolledPrograms')}}"

                }
            },
            error: function(xhr) {
                console.error(xhr);
                $('#moduleWrap').html('<p>An error occurred while fetching courses.</p>');
            }
        });
    });
@endsection

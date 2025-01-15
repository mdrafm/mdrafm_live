

@extends('../layouts.app')
@section('content')

  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">Practice Test</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard min-vh-100 py-4">
        <div class="container">

            <table class="table table-hover">
                <thead>
                    <th>Sl No</th>
                    <th>Subject Name</th>
                    <th>Exam Status</th>
                    <th>Mark</th>
                    <th>Action</th>

                </thead>
                <tbody>

                    @foreach($tests as $test)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $test->subject->subject_name }}</td>
                        <td>
                            @if (in_array($test->id, $examStatus))
                                <span class="text-success">Completed</span>
                            @else
                                <span class="text-danger">Not Completed</span>
                            @endif
                        </td>
                        <td>NA</td>
                        <td>
                            @if (!$allCompleted)
                               <p class="text-danger">Complete All the Topics</p>
                               @elseif (in_array($test->id, $examStatus))
                               <button type="button" data-testid="{{$test->id}}" class="btn btn-success showResult">View Result</button>

                               @else
                               {{-- <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#examModal">Start Exam</a> --}}
                               <form action="{{ route('start.test') }}" method="POST">
                                @csrf
                                <input type="hidden" name="subject_id" value="{{ $test->subject_id }}">
                                <input type="hidden" name="test_id" value="{{ $test->id }}">
                                <input type="hidden" name="exam_duration" value="{{ $test->exam_duration }}">
                                <input type="hidden" name="total_question" value="{{ $test->total_question }}">
                                <input type="hidden" name="mark_per_right_ans" value="{{ $test->mark_per_right_ans }}">
                                <input type="hidden" name="marks_per_wrong_answer" value="{{ $test->marks_per_wrong_answer }}">
                                <button type="submit" class="btn btn-primary">Practice Text</button>


                              </form>


                            @endif



                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="queryModalLabel">Result Summary</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                        </div>
                    </div>
                </div>
            </div>
         </div>
  </section>

@endsection

@section('script')
$(document).ready(function () {
 $('.showResult').on('click', function () {
    var testId = $(this).data('testid');
    console.log(testId);
    $.ajax({
        type: 'POST',
        url: '{{ route('show.result') }}',
        data: {
            testId: testId
            },
            success: function (data) {
console.log(data);
                $('#resultModal').modal('show');
                var html = `
                <div class="card" style="width: 25rem;">
                    <div class="card-body">
                        <h5 class="card-title text-warning">Exam Information</h5>
                        <p><strong>No. of Questions:</strong> ${data.total_questions}</p>
                        <p><strong>Marks per Correct Answer:</strong> ${data.eachWriteAns}</p>
                        <p><strong>Marks per Incorrect Answer:</strong>0</p>
                        <hr>
                        {{-- <p><strong>Marks Deducted per Wrong Answer:</strong> ${data.eachWrongAns??0}</p> --}}
                        <p><strong>Correct Answers:</strong> ${data.correct_answers}</p>
                        <p><strong>Incorrect Answers:</strong> ${data.incorrect_answers??'0'}</p>
                        <p><strong>Unattended Questions:</strong> ${data.unanswered_questions}</p>
                        <hr>
                        <p><strong>Total Marks Secured:</strong> ${data.final_answer}</p>
                    </div>
                </div>
            `;
                console.log(html);
                $('#resultModal .modal-body').html(html);
                }
    });
});


});
@endsection



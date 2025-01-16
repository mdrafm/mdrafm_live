@extends('../layouts.app')
@section('content')

  <div class="pagetitle">
    <h1>Feedback</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">Feedback</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard min-vh-100 py-4">
      <div class="container">
          <!-- End Logo -->

             <div class="topic feedback">
               <table class="table table-striped" id="users_tbl">
                 <thead>

                   <tr>
                     <th scope="col">SL No</th>
                     {{-- <th scope="col">Session Name</th> --}}
                     <th scope="col">Topic Name</th>
                     <th scope="col">Action</th>
                   </tr>
                 </thead>
                 <tbody style="font-size: 13px;">

                    @foreach($subjects as $subject)
                    <tr>
                        <td colspan="3" ><strong class="text-primary" >Session Name - {{$subject->subject_name}}</strong></td>
                    </tr>

                        @foreach ($subject->topics as $topics )
                        <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td> {{ $topics->topic_name }}</td>
                        <td class="d-flex ">
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input rd" type="radio" name="feedback_{{ $topics->id }}" value="5">
                                    <label class="form-check-label fdName" for="inlineRadio1">Excellent</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input rd" type="radio" name="feedback_{{ $topics->id }}" value="4">
                                    <label class="form-check-label fdName" for="inlineRadio2"> Very
                                        Good</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input rd" type="radio" name="feedback_{{ $topics->id }}" value="3">
                                    <label class="form-check-label fdName" for="inlineRadio3">Good</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input rd" type="radio" name="feedback_{{ $topics->id }}" value="2">
                                    <label class="form-check-label fdName" for="inlineRadio3">Average</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input rd" type="radio" name="feedback_{{ $topics->id }}" value="1">
                                    <label class="form-check-label fdName" for="inlineRadio4">Needs
                                        Improvement</label>
                                </div>
                            </div>


                        </td>
                    </tr>
                         @endforeach





                    @endforeach
                 </tbody>
               </table>
             </div>

             <div class="feedback_message">
                <p class="text-dark fw-bold" >What is your suggestion for improving the training program ?
                    (Max 250 Words)</p>
                 <textarea class="form-control" id="class_feedback" name="class_feedback" rows="5"></textarea>
                <button type="submit" class="btn btn-primary mt-3">Submit Feedback</button>
             </div>

         </div>
  </section>

@endsection

@section('script')
$(document).ready(function(){
    CKEDITOR.replace('class_feedback');
})

@endsection

<?php $__env->startSection('content'); ?>

  <div class="pagetitle">
    <h1>Practice Test</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">Practice Test</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard min-vh-100 py-4">
        <div class="container">
          <div class="examInfo">
            <div class="card " style="width: 18rem;">
                <div class="card-body">
                  <h5 class="card-title text-warning ">Exam Information</h5>
                  <p><strong>Exam duration :</strong> <?php echo e($exam_duration); ?> minutes</p>
                  <p><strong>No. of questions :</strong> <?php echo e($total_question); ?></p>
                  <p><strong>Each question have  :</strong> <?php echo e($mark_per_right_ans); ?> marks</p>
                  <p><strong>Each write ans  :</strong> <?php echo e($mark_per_right_ans); ?>  marks</p>
                  <p><strong>Each wrong ans  :</strong> <?php echo e($marks_per_wrong_answer); ?> marks</p>

                  <button class="btn btn-success" id="startExamBtn"
                  data-subjectid="<?php echo e($subject_id); ?>"
                  data-duration="<?php echo e($exam_duration); ?>"
                  data-total_question="<?php echo e($total_question); ?>"
                  >Start Exam</button>
                </div>
            </div>

          </div>
          <div class="examContainer d-none" >
            <h2>Online Exam</h2>
            <div id="timerDisplay" class="d-flex justify-content-end text-danger fs-6 ">Time Remaining: 0:00</div>
            <div id="questionContainer"></div>
            <div id="navigationButtons" class="mt-2 mb-2 " >
                <button id="prevBtn" class="btn btn-warning" disabled>Previous</button>
                <button id="nextBtn" class="btn btn-success" disabled>Next</button>
                <button id="saveBtn" class="btn btn-primary">Save Answer</button>
                <button id="finishBtn" class="btn btn-danger">Finish Exam</button>
            </div>
            <div id="questionList"></div>
          </div>
          <form id="redirectForm" action="<?php echo e(route('practice-test')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="subject_id" value="<?php echo e($subject_id); ?>">

        </form>
            

         </div>
  </section>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
$(document).ready(function () {
    let currentQuestionIndex = 0;
    let questions = [];
    const answers = {};
    var subjectId = 0;
    let timer; // For tracking the countdown
    let timeRemaining=600 // Store the remaining time in seconds

    const questionContainer = $('#questionContainer');
    const questionList = $('#questionList');
    const prevBtn = $('#prevBtn');
    const nextBtn = $('#nextBtn');
    const saveBtn = $('#saveBtn');
    const timerDisplay = $('#timerDisplay'); // Timer display element
//console.log(timerDisplay)

    $('#startExamBtn').on('click',function(){
        $('.examInfo').addClass('d-none');
        $('.examContainer').removeClass('d-none');

         subjectId = $(this).data('subjectid');
        let duration = $(this).data('duration');
        let total_question = $(this).data('total_question');
        console.log(subjectId,total_question)
        loadQuestions(subjectId,total_question)
    })
    // Load questions using AJAX
    function loadQuestions(subjectId,total_question) {
        $.ajax({
            url: '<?php echo e(route('fetch.questions')); ?>',
            type: 'POST',
            data:{subjectId:subjectId,subjectId:subjectId},
            dataType: 'json',
            success: function (response) {
                console.log(response);
                questions = response;
                renderQuestion(currentQuestionIndex);
                renderQuestionList();
                startTimer()
            },
            error: function (xhr, status, error) {
                alert('Failed to load questions. Please try again.');
                console.error(error);
            },
        });
    }

    // Render the current question
    function renderQuestion(index) {
        const question = questions[index];
        questionContainer.html(`
            <h4>Question ${index + 1}: ${question.question_title}</h4>
            <div>
                ${question.options
                    .map(
                        (option) => `
                    <div>
                        <label>
                            <input type="radio" name="answer" value="${option.option_label}"
                                ${answers[question.id] === option.option_label ? 'checked' : ''} />
                            ${option.option_label}: ${option.option_value}
                        </label>
                    </div>
                `
                    )
                    .join('')}
            </div>
        `);

        prevBtn.prop('disabled', index === 0);
        nextBtn.prop('disabled', index === questions.length - 1);
    }
    // Start the timer
    function startTimer() {
        updateTimerDisplay();
        timer = setInterval(() => {
            timeRemaining--;
            if (timeRemaining <= 0) {
                clearInterval(timer);
                finishExam();
            }
            updateTimerDisplay();
        }, 1000);
    }

    // Update the timer display
    function updateTimerDisplay() {
        const minutes = Math.floor(timeRemaining / 60);
        const seconds = timeRemaining % 60;
        timerDisplay.text(`Time Remaining: ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`);
    }
    $('#finishBtn').on('click',function(){
        finishExam();
    })
    // Finish the exam automatically
    function finishExam() {
        alert('Time is up! The exam is now finished.');
        document.getElementById('redirectForm').submit();
    }

    // Render question list
    function renderQuestionList() {
        questionList.html(
            questions
                .map(
                    (q, i) => `
                <button class="question-btn btn btn-info" id="questionButton_${i}" data-index="${i}">
                    ${i + 1}
                </button>
            `
                )
                .join('')
        );
        $('.question-btn').on('click', function () {
            currentQuestionIndex = parseInt($(this).data('index'));
            renderQuestion(currentQuestionIndex);
        });
    }

    // Save the current answer
    saveBtn.on('click', function () {
        const selectedOption = $('input[name="answer"]:checked').val();
        const test_id = <?php echo json_encode($test_id, 15, 512) ?>;
        console.log(test_id);
        if (selectedOption) {
            const questionId = questions[currentQuestionIndex].id;
            answers[questionId] = selectedOption;

            // Save answer using AJAX
            $.ajax({
                url: '<?php echo e(route('save-answer')); ?>',
                type: 'POST',
                data: {
                    question_id: questionId,
                    answer: selectedOption,
                    test_id:test_id
                },
                success: function (response) {
                    console.log(response);
                    if (response.status === 'success') {
                        // Update the button color in the question list
                        const questionButton = $(`#questionButton_${currentQuestionIndex}`);
                        questionButton.removeClass('btn-info');
                        questionButton.addClass('btn-success'); // Add a CSS class for answered questions
                    }
                },
                error: function (xhr, status, error) {
                    alert('Failed to save answer. Please try again.');
                    console.error(error);
                },
            });
        } else {
            alert('Please select an answer before saving!');
        }
    });

    // Navigate to the next or previous question
    nextBtn.on('click', function () {
        if (currentQuestionIndex < questions.length - 1) {
            currentQuestionIndex++;
            renderQuestion(currentQuestionIndex);
        }
    });

    prevBtn.on('click', function () {
        if (currentQuestionIndex > 0) {
            currentQuestionIndex--;
            renderQuestion(currentQuestionIndex);
        }
    });

    // Load questions for a specific subject (replace 1 with your subject ID)


});

<?php $__env->stopSection(); ?>



<?php echo $__env->make('../layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\online_module\resources\views/trainee/startTest.blade.php ENDPATH**/ ?>
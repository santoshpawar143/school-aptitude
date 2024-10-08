$(document).ready(function () {
    //creating a session variable
    Data = sessionStorage.getItem('testData');
    if (Data) {
        cardData = JSON.parse(Data);
        selected_ans = cardData.selected_ans;
        if (cardData.selected_ans) {
            var $resultContainer = $('#result_container');
            $resultContainer.css('display', 'flex');
            const cleanedString = cardData.selected_ans.replace(/&quot;/g, '"');
            recheckCard(cleanedString);
        }
        else {
            $('#test_card').show();
        }
    }
    //function for rechecking submitted test
    function recheckCard(selected_ans_json) {
        var user_data = JSON.parse(selected_ans_json);
        let cardData, data, chapter_name, chapterId;
        if (Data) {
            cardData = JSON.parse(Data);
            data = cardData.testData; // This is your data array
            chapter_name = cardData.chapterName;
            chapterId = cardData.chapterId;
        }

        if (data.length > 0) {
            let formHtml = '';
            formHtml += `<div class="quiz-header mt-2">
                        <label class="form-label">Review</label>
                         <h6 class="mt-3">Chapter Name :${chapter_name}</h6> 
                     </div>`;

            data.forEach((item, index) => {
                const selectedAnswer = user_data[index] || null; // Use user_data for selected answers
                formHtml += `
                <div class="step-container ${index === 0 ? 'active' : ''} m-2" id="step_${index}" data-id="${item.id}">
                    <p class="quiz-question">Q. ${index + 1} ${item.question}</p>
                    <div class="form-check p-2 ">
                        <input class="" type="radio" name="question_${index}" id="option_a_${index}" value="A" ${selectedAnswer === 'A' ? 'checked' : ''} disabled>
                        <label class="form-check-label" for="option_a_${index}">A) ${item.option_a}</label>
                    </div>
                    <div class="form-check p-2 ">
                        <input class="" type="radio" name="question_${index}" id="option_b_${index}" value="B" ${selectedAnswer === 'B' ? 'checked' : ''} disabled>
                        <label class="form-check-label" for="option_b_${index}">B) ${item.option_b}</label>
                    </div>
                    <div class="form-check p-2 ">
                        <input class="" type="radio" name="question_${index}" id="option_c_${index}" value="C" ${selectedAnswer === 'C' ? 'checked' : ''} disabled>
                        <label class="form-check-label" for="option_c_${index}">C) ${item.option_c}</label>
                    </div>
                    <div class="form-check p-2 ">
                        <input class="" type="radio" name="question_${index}" id="option_d_${index}" value="D" ${selectedAnswer === 'D' ? 'checked' : ''} disabled>
                        <label class="form-check-label" for="option_d_${index}">D) ${item.option_d}</label>
                    </div>
                    ${index === 0 ? '' : `<button class="btn btn-secondary mt-3 prev-step" data-current-step="${index}">Previous</button>`}
                    ${index === data.length - 1 ? '' : `<button class="btn btn-primary mt-3 next-step" data-next-step="${index + 1}" data-current-step="${index}">Next</button>`}
                    ${index === data.length ? '' : `<button class="btn btn-danger mt-3" id="review-close" data-current-step="${index}">Close</button>`}
                </div>`;
            });

            $('#test_create').html(formHtml);

            // Highlight selected answers and check against correct answers
            data.forEach((item, index) => {
                const selectedAnswer = user_data[index] ? user_data[index].trim() : null; // Ensure we trim whitespace
                const correctAnswer = item.correct_ans; // Use correct_ans from the data array

                $(`input[name="question_${index}"]`).closest('.form-check').removeClass('bg-success bg-danger bg-warning');

                if (!selectedAnswer) {
                    // If no option is selected, indicate this
                    $(`input[name="question_${index}"]`).closest('.form-check').addClass('bg-warning');
                    // Highlight the correct answer
                    if (correctAnswer) {
                        $(`input[name="question_${index}"][value="${correctAnswer}"]`).closest('.form-check').removeClass('bg-success bg-danger bg-warning').addClass('bg-success');
                    }
                } else {
                    // Add new class based on correctness
                    if (selectedAnswer === correctAnswer) {
                        $(`input[name="question_${index}"][value="${selectedAnswer}"]`).closest('.form-check').addClass('bg-success');
                    } else {
                        $(`input[name="question_${index}"][value="${selectedAnswer}"]`).closest('.form-check').addClass('bg-danger');
                        // Highlight the correct answer
                        if (correctAnswer) {
                            $(`input[name="question_${index}"][value="${correctAnswer}"]`).closest('.form-check').addClass('bg-success');
                        }
                    }
                }
            });

            // Handle next and previous buttons
            $('.next-step').on('click', function () {
                const currentStep = $(this).data('current-step');
                const nextStep = $(this).data('next-step');
                $('#step_' + currentStep).removeClass('active');
                $('#step_' + nextStep).addClass('active');
            });

            $('.prev-step').on('click', function () {
                const currentStep = $(this).data('current-step');
                const prevStep = currentStep - 1;
                $('#step_' + currentStep).removeClass('active');
                $('#step_' + prevStep).addClass('active');
            });
        }
    }
    //close button of review card
    $(document).on('click', '#review-close', function () {
        sessionStorage.clear();
        window.history.back();
    });
    //function for creating test
    function showTestCard() {
        var $testCard = $('#test_card');
        var $resultContainer = $('#result_container');

        $testCard.addClass('fade-out');
        setTimeout(function () {
            $testCard.hide();
            $resultContainer.css('display', 'flex');
        }, 500);

        // const Data = sessionStorage.getItem('testData');
        if (Data) {
            const cardData = JSON.parse(Data);
            testData = cardData.testData;
            chapter_name = cardData.chapterName;
            chapterId = cardData.chapterId;
        }

        if (testData.length > 0) {
            let formHtml = '';
            let question_count = 0;
            formHtml += ` <div class="quiz-header mt-2">
                                    <label for="slider" id='timer' class="form-label">60</label>
                                  <input type="range" class="form-controll" id="slider" step="1" min="0" max="100" disabled> 
                                  <h6 class="mt-3">Chapter Name :${chapter_name}</h6> 
                                </div>`;
            let buttonHtml = '<div class="question-buttons mt-3">';
            testData.forEach((item, index) => {
                question_count = (index + 1) * 60;
                buttonHtml += `
                <button class="btn btn-outline-primary question-button btn-warning" data-index="${index}">${index + 1}</button>
            `;
                formHtml += `
                            <div class="step-container ${index === 0 ? 'active' : ''} m-2 " id="step_${index}" data-id="${item.id}">
                                <p class="quiz-question">Q. ${index + 1} ${item.question}</p>
                                <div class="form-check   p-2 quiz-options">
                                   <input class="form-check-input" type="radio" name="question_${index}" id="option_a_${index}" value="A">
                                    <label class="form-check-label" for="option_a_${index}">
                                        A) ${item.option_a}
                                    </label>
                                </div>
                                <div class="form-check  p-2 quiz-options">
                                   <input class="form-check-input" type="radio" name="question_${index}" id="option_b_${index}" value="B">
                                    <label class="form-check-label" for="option_b_${index}">
                                       B)  ${item.option_b}
                                    </label>
                                </div>
                                <div class="form-check  p-2 quiz-options">
                                   <input class="form-check-input" type="radio" name="question_${index}" id="option_c_${index}" value="C">
                                    <label class="form-check-label" for="option_c_${index}">
                                      C)   ${item.option_c}
                                    </label>
                                </div>
                                <div class="form-check  p-2 quiz-options">
                                    <input class="form-check-input" type="radio" name="question_${index}" id="option_d_${index}" value="D">
                                    <label class="form-check-label" for="option_d_${index}">
                                       D) ${item.option_d}
                                    </label>
                                </div>
                                 <div class="form-check">
                                    <input class="form-input" type="hidden" name="question_${index}"  value="${item.correct_ans}">
                                    
                                </div>
                                ${index === 0 ? '' : '<button class="btn btn-secondary mt-3 prev-step" data-current-step="' + index + '">Previous</button>'}
                                ${index === testData.length - 1 ? ' <button type="button" class=" btn btn-success mt-3 text-end"  id="save_test" data-id="' + chapterId + '"> Submit</button > ' : '<button class="btn btn-primary mt-3 next-step" data-next-step="' + (index + 1) + '" data-current-step="' + index + '">Next</button>'}
                            </div>`;
            });
            buttonHtml += '</div>';
            $('#test_create').html(formHtml + buttonHtml);
            if ($('#slider').length) {
                $('#slider').attr({
                    'min': 0,
                    'max': question_count
                });
            } else {
                console.log('Element with ID "slider" is not present.');
            }

            halfcount = question_count / 2;
            var newImageUrl = 'assets/img/happiness.png'; // Replace with the path to your new image
            setStyle(newImageUrl);
            function UpdateTimer() {
                if (question_count <= 0) {
                    clearInterval(timerInterval);
                    $('#timer').text("Time's up!");
                    $('#slider').val(0);
                    var newImageUrl = 'assets/img/dead-skin.png'; // Replace with the path to your new image
                    setStyle(newImageUrl);
                    submit_test(chapterId);
                } else {
                    question_count--;
                    const minutes = Math.floor(question_count / 60);
                    const seconds = question_count % 60;
                    $('#timer').text(`${minutes}:${seconds < 10 ? '0' : ''}${seconds}`);
                    $('#slider').val(question_count);

                    if (question_count == halfcount) {
                        var newImageUrl = 'assets/img/nervous.png'; // Replace with the path to your new image
                        setStyle(newImageUrl);
                    }
                    if (question_count == halfcount / 2) {
                        var newImageUrl = 'assets/img/toxic.png'; // Replace with the path to your new image
                        setStyle(newImageUrl);
                    }
                }
            }
            var timerInterval = setInterval(UpdateTimer, 1000);



            // Event handler for question buttons
            $('.question-button').on('click', function () {
                const index = $(this).data('index');

                // Hide all question containers and show the selected question
                $('.step-container').removeClass('active');
                $('#step_' + index).addClass('active');

                // Update button colors
                updateButtonColors();
            });

            // Handle next and previous buttons
            $('.next-step').on('click', function () {
                const currentStep = $(this).data('current-step');
                const nextStep = $(this).data('next-step');
                $('#step_' + currentStep).removeClass('active');
                $('#step_' + nextStep).addClass('active');
                updateButtonColors();
            });

            $('.prev-step').on('click', function () {
                const currentStep = $(this).data('current-step');
                const prevStep = currentStep - 1;
                $('#step_' + currentStep).removeClass('active');
                $('#step_' + prevStep).addClass('active');
                updateButtonColors();
            });

        }
    }
    //for displaying test card
    $('#start_test').on('click', function () {
        showTestCard();
    });
    //function for submitting test
    function submit_test(chapter_id) {
        let totalMarks = 0;
        let totalQuestions = $('.step-container').length;
        let correctAnswersCount = 0;

        // Collect user responses
        let userResponses = [];
        $('.step-container').each(function (index) {
            let selectedAnswer = $(this).find('input[name="question_' + index + '"]:checked').val();
            let correctAnswer = $(this).find('input.form-input').val(); // Assuming the correct answer is in a hidden input field
            userResponses.push({
                question_id: $(this).data('id'),
                selected_answer: selectedAnswer,
                correct_answer: correctAnswer
            });

            if (selectedAnswer === correctAnswer) {
                correctAnswersCount++;
            }
        });
        let result = "fail";
        if (correctAnswersCount >= totalQuestions / 2) {
            result = "pass";
        }
        // Calculate total marks
        totalMarks = correctAnswersCount;
        reveiwData = {
            userResponses: userResponses,
        };
        const selected_ans = [];
        userResponses.forEach(response => {
            selected_ans.push(response.selected_answer);
        });

        const selected_ans_json = JSON.stringify(selected_ans);

        var formData = {
            chapter_id: chapter_id,
            marks_obtained: totalMarks,
            totalMarks: totalQuestions,
            selected_ans: selected_ans_json,
            result: result
        };

        $.ajax({
            url: '/save_test', // Correct URL for the 'store' method
            type: 'GET',
            data: formData,
            success: function (response) {
                Swal.fire({
                    title: "Your Response Has Been Successfully Saved !!!!!",
                    html: 'You got <strong>' + formData.marks_obtained + '</strong> / <strong>' + formData.totalMarks + '</strong> right.<br>Result: ' + result,
                    width: '90vw', // Adjust width to be responsive
                    maxWidth: '100px', // Set a max-width to ensure it doesn't get too large on larger screens
                    color: "#716add",
                    imageUrl: "assets/img/success.gif",
                    imageAlt: "Custom image",
                    showCancelButton: true,
                    confirmButtonText: "Ok",
                    cancelButtonText: "Review",
                    backdrop: `
                    rgba(0,0,123,0.4)
                    left top
                    no-repeat
                `,
                    customClass: {
                        container: 'responsive-swal-container', // Custom class for additional styling
                        popup: 'responsive-swal-popup' // Custom class for additional styling
                    },

                }).then((result) => {
                    if (result.isConfirmed) {
                        sessionStorage.clear();
                        window.history.back();
                    }
                    else {
                        recheckCard(selected_ans_json);
                    }
                });
            },
            error: function (xhr) {
                console.log(xhr);
            }
        });
    }

    function updateButtonColors() {
        $('.question-button').each(function (i) {
            if ($(`input[name="question_${i}"]:checked`).length > 0) {
                $(this).removeClass('btn-warning').addClass('btn-primary text-white');
            } else {
                $(this).removeClass('btn-success text-white').addClass('btn-warning');
            }
        });
    }

    $(document).on('click', '#save_test', function () {
        updateButtonColors();
        let skipped_questions = 0;
        $('.question-button').each(function () {
            // Check if the button has the 'btn-primary' class
            if ($(this).hasClass('btn-warning')) {
                skipped_questions++;
            }
        });
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to submit test",
            text: "skipped questions :" + skipped_questions,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, submit it!",
        }).then((result) => {
            if (result.isConfirmed) {

                $('#timer').text("Time's up!");
                $('#slider').val(0);
                submit_test($(this).data('id'));
            }
        });
    });



    //function for setting different images on slider based on remaining time
    //style js
    function setStyle(newImageUrl) {
        var style = document.createElement('style');
        style.innerHTML = `
    /* Basic styling for the slider */
    input[type="range"] {
        -webkit-appearance: none; /* Remove default styling in WebKit browsers */
        width: 100%;
        height: 8px; /* Track height */
        background: #ddd; /* Track color */
        border-radius: 5px;
        outline: none;
        opacity: 0.7;
        transition: opacity .15s ease-in-out;
    }

    /* Styling for WebKit browsers */
    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none; /* Remove default styling in WebKit browsers */
        width: 40px; /* Thumb width */
        height: 40px; /* Thumb height */
        background-image: url('${newImageUrl}'); /* URL of smiling emoji */
        background-size: cover; /* Resize image to fit thumb */
        cursor: pointer;
        border-radius: 50%; /* Circular thumb */
        border: 2px solid #333; /* Thumb border color */
        background-color: transparent; /* Ensure background color does not override image */
    }

`;
        // Append the <style> element to the document head
        document.head.appendChild(style);
    }





});
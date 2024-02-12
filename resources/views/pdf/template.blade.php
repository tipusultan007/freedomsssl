<!-- resources/views/pdf/template.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PDF Report</title>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

<button id="generate-pdf-button">Generate PDF</button>
<div id="progress-bar-container">
  <div id="progress-bar" style="width: 0%;"></div>
</div>

<script>
  $(document).ready(function() {
    // Function to check the report generation progress
    function checkProgress(reportId) {
      $.ajax({
        url: '/check-report-progress/' + reportId,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          // Update the progress bar
          $('#progress-bar').css('width', response.progress + '%');

          // Check if the progress is 100% (complete)
          if (response.progress === 100) {
            // Hide the progress bar or perform other actions
            $('#progress-bar-container').hide();
          } else {
            // Continue checking progress after a delay (e.g., 1 second)
            setTimeout(function() {
              checkProgress(reportId);
            }, 1000);
          }
        },
        error: function(error) {
          console.error('Error checking progress:', error);
        }
      });
    }

    // Event listener for the "Generate PDF" button
    $('#generate-pdf-button').click(function() {
      // Show the progress bar container
      $('#progress-bar-container').show();

      // AJAX request to initiate report generation
      $.ajax({
        url: '/generate-pdf',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          // Log success message or perform other actions
          console.log(response.message);

          // Start checking progress
          checkProgress(response.reportId);
        },
        error: function(error) {
          console.error('Error generating PDF:', error);
        }
      });
    });
  });
</script>

</body>
</html>

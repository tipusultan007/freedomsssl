<!-- resources/views/emails/export/completed.blade.php -->

<p>Your export file '{{ $filename }}' has been completed and is ready for download.</p>

<a href="{{ $downloadUrl }}" target="_blank" style="display:inline-block; padding:10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Download Now</a>

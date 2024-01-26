@php
$containerFooter = (isset($configData['contentLayout']) && $configData['contentLayout'] === 'compact') ? 'container-xxl' : 'container-fluid';
@endphp

<!-- Footer-->
<footer class="content-footer footer bg-footer-theme">
  <div class="{{ $containerFooter }}">
    <div class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
      <div>
        © <script>document.write(new Date().getFullYear())
      </script>, ফ্রিডম শ্রমজীবি সমবায় সমিতি লিমিটেড। Developed By <a href="https://umairit.com" target="_blank" class="fw-medium">UMAIR IT - Software Solutions</a>
      </div>
    </div>
  </div>
</footer>
<!--/ Footer-->

$path = 'e:\Saklin Mustak\All Websites\Doctorwala\website\resources\views\user-medical-history.blade.php'
$content = Get-Content $path -Raw
$js = "
    <script>
        function switchTab(event, tabId) {
            document.querySelectorAll('.mht-tab').forEach(tab => { tab.classList.remove('active'); });
            event.currentTarget.classList.add('active');
            document.querySelectorAll('.tab-content').forEach(content => { content.classList.remove('active'); });
            if (tabId === 'uploaded') { document.getElementById('uploadedRecords').classList.add('active'); }
            else { document.getElementById('generatedRecords').classList.add('active'); }
        }
    </script>
"
if ($content -match '@endsection') {
    $content = $content.Replace('@endsection', $js + '@endsection')
    Set-Content $path $content -Encoding UTF8
    Write-Output "Successfully updated file"
} else {
    Write-Error "Could not find @endsection"
}

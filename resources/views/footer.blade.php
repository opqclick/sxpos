
<footer class="dash-footer">
    <div class="footer-wrapper">
        <div class="py-1">
            <span class="text-muted">{{-- {{ __('Copyright') }} --}} <!-- &copy; -->
                {{-- {{ env('FOOTER_TEXT') ? env('FOOTER_TEXT') : Utility::getValByName('footer_text') }} --}}
                {{ Utility::getValByName('footer_text') ? Utility::getValByName('footer_text') : config('app.name', 'POSGo') }}
                {{-- {{ date('Y') }} --}}</span> 

        </div>
    </div>
</footer>

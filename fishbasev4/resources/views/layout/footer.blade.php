<footer class="clearfix" >
    <p><b>FishBase v4.0</b></p>
    <p>
        <!-- For web site technical issues only: <a href="/technical-issues">Webmaster</a><br>
        For comments: <a href="/contact">Comments & Corrections</a>-->

        
		<form name="mailx_$i" method="post" action="https://fishbase.us/mail/MailForm.php"><p>For comments: 
					<input type="hidden" name="code" value="28">
					<input type="hidden" name="pagefrom" value=" {{ url()->current() }} ">
					<a href="javascript:document.mailx_$i.submit()">Comments & Corrections</a>
					</p></form>
		<br>
		
    </p>
    <ul class="social">
        <li ><a href="https://www.facebook.com/FishBase" target="_blank" rel="noopener" title="FishBase on Facebook"><img src="{{ asset('assets/gfx/Facebook.svg') }}" alt="Facebook Logo"></a></li>
        <li ><a href="https://twitter.com/fishbaseproject" target="_blank" rel="noopener" title="FishBase on Twitter"><img src="{{ asset('assets/gfx/Twitter.svg') }}" alt="Twitter Logo"></a></li>

    </ul>
</footer>
@include('shared/icons')
@stack('footer-js')
<script src="{{ asset('assets/js/app.js') }}" type="text/javascript"></script>
</body>
</html>

<footer class="app-footer">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-md-3">
				<a href="{{ url('/') }}" class="footer-logo">
					<img src="{{ asset('logo-light.png') }}" alt="Logo">
					<span>CityU Pics</span>
				</a>
			</div>
			<div class="col-xs-6 col-sm-3">
				<h3 class="nav-title">@lang('messages.footer.info.title')</h3>
				<ul class="nav">
					<li>
						<a href="/about"><i class="fa fa-exclamation-circle"></i>&nbsp;@lang('messages.footer.info.about')</a>
					</li>
					<li>
						<a href="/faq"><i class="fa fa-question-circle"></i>&nbsp;@lang('messages.footer.info.faq')</a>
					</li>
					<li>
						<a href="/privacy"><i class="fa fa-user-secret"></i>&nbsp;@lang('messages.footer.info.privacy')</a>
					</li>
				</ul>
			</div>
			<div class="col-xs-6 col-sm-3">
				<h3 class="nav-title">@lang('messages.footer.dev.title')</h3>
				<ul class="nav">
					<li>
						<a href="/contribute"><i class="fa fa-code-fork"></i>&nbsp;@lang('messages.footer.dev.contribute')</a>
					</li>
					<li>
						<a href="/develop"><i class="fa fa-book"></i>&nbsp;@lang('messages.footer.dev.history')</a>
					</li>
				</ul>
			</div>
			<div class="col-xs-12 col-sm-3">
				<h3 class="nav-title">@lang('messages.footer.links.title')</h3>
				<ul class="nav">
					<li>
						<a href="https://www.cityu.edu" target="_blank">CityU of Seattle</a>
					</li>
					<li>
						<a href="https://www.linkedin.com/edu/school?id=19640&trk=edu-cp-title" target="_blank">LinkedIn</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="footer-copyright">
					<p>&copy; {{ \Carbon\Carbon::now()->year }} CityU Pics.</p>
				</div>
			</div>
		</div>
	</div>
</footer>
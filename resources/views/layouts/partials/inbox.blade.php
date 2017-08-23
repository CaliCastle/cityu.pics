<div class="Inbox">
	<div class="Inbox__title text-center">
		<p v-if="User.unread">@{{ User.unread }} {{ trans_choice('messages.navbar.inbox.unread', Auth::user()->unread) }}</p>
		<p v-else>@lang('messages.navbar.inbox.empty')</p>
	</div>
	<div class="Inbox__inner SlimScroll">
		<div class="Inbox__empty zoom" v-if="!User.unread" v-cloak>
			<img src="/images/empty-box.png" alt="Empty inbox">
		</div>
		<ul class="Inbox__list List--naked" v-else>
			<li class="Inbox__item animated" v-for="(Inbox, index) in Inboxes">
				<a class="waves-effect waves-light" href="#" @click.prevent="readInbox" :inbox-id="Inbox.id" :inbox="index" :data-link="Inbox.link">
					<div class="badge badge-success" :class="'inbox-type-' + Inbox.type" v-if="Inbox.type != 'user'"></div>
					<div class="badge badge-avatar inbox-type-user" :style="Inbox.avatar ? 'background-image: url(' + Inbox.avatar + ')' : ''" v-else></div>
					<div class="Inbox__message" :class="{'full': !Inbox.image}">
						<p class="details" v-html="Inbox.message"></p>
						<time class="timeago" :datetime="Inbox.time"></time>
					</div>
					<div class="Inbox__image" v-if="Inbox.image" :style="'background-image: url(' + Inbox.image + ')'"></div>
				</a>
			</li>
		</ul>
	</div>
	<div class="Inbox__footer">
		{{-- TODO: Add href link --}}
		<a href="#">@lang('messages.navbar.inbox.see-all')</a>
		<a href="#" class="clear-all waves-effect waves-light" @click.prevent="readAllInbox" v-if="Inboxes.length"><i class="fa fa-trash-o"></i></a>
	</div>
</div>
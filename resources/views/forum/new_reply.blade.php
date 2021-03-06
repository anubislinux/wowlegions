<section class="Section Section--secondary">
<div data-topic-post="true" tabindex="0" class="TopicForm is-editing" id="topic-reply">

<header class="TopicForm-header">
<h1 class="TopicForm-heading">@if($topic->closed) @lang('forum.TopicFormHeadingClosed') @else @lang('forum.TopicFormHeading') @endif</h1>
</header>
<div class="TopicForm-content">
<aside class="TopicForm-author" data-topic-form="{'userId': {{ Auth::user()->id }}}">
<div class="Author" id="" data-topic-post-body-content="true"><a href="{{ route('characters-simple', [$active->name]) }}" class="Author-avatar "><img src="/images/avatars/wow/4-0.jpg" alt="" /></a><div class="Author-details"> <span class="Author-name">
<a class="Author-name--profileLink" href="{{ route('characters-simple', [$active->name]) }}">{{ $active->name }}</a>
</span>
<span class="Author-posts">
<a class="Author-posts" href="/search?a={{ Auth::user()->name }}" data-toggle="tooltip" data-tooltip-content="@lang('forum.view_message_history')" data-original-title="" title="">
@lang('forum.count_messages', ['count' => Auth::user()->posts_count])
</a>
</span></div></div>
<div class="Author-ignored is-hidden" data-topic-post-ignored-author="true">
<span class="Author-name">
<a class="Author-name--profileLink" href="{{ route('characters-simple', [$active->name]) }}">{{ $active->name }}</a>
</span>
<div class="Author-posts Author-posts--ignored">@lang('forum.ignored')</div></div>
<div class="SelectCharacter-button--container">
                <button class="TopicForm-button TopicForm-button--selectCharacter" type="button">
                  <span class="Button-content">Изменить персонажа</span>
                </button>
              </div>
</aside>
@if(!Auth::user()->role > 2 && $topic->closed)
<div class="LoginPlaceholder-details"> <div class="LogIn-message LogIn-message--center"> @lang('forum.thread_is_locked')</div> </div>
@else
<form class="Form" action="{{ route('forum.topic.reply.create', [$topic->category->id, $topic->id])}}" id="topic-reply-form" method="post" data-post-form="true">
<fieldset>
{{ csrf_field() }}
<input type="hidden" name="sessionPersist" value="forum.topic.post"/>
</fieldset>
<div class="TopicForm-group TopicForm-group-content TopicForm-group--isActivated" data-topic-form="true">
<textarea id="detail" name="detail" class="TopicForm-control needsclick TopicForm-control--detail" data-topic-post-body-edit="true" tabindex="1" spellcheck="true" required="required"></textarea>
<div class="BmlToolbar" id="BmlToolbar">
<div class="BmlToolbar--content">
<span data-toggle="tooltip" data-tooltip-content="@lang('forum.bold')" data-topic-post-button="true" data-trigger="bml.bold.bmltoolbar" class="BmlToolbar-button" data-original-title="" title="">
<i class="Icon Icon--16 Icon--bold"></i>
</span>
<span data-toggle="tooltip" data-tooltip-content="@lang('forum.italics')" data-topic-post-button="true" data-trigger="bml.italics.bmltoolbar" class="BmlToolbar-button" data-original-title="" title=""><i class="Icon Icon--16 Icon--italics"></i>
</span>
<span data-toggle="tooltip" data-tooltip-content="@lang('forum.underline')" data-topic-post-button="true" data-trigger="bml.underline.bmltoolbar" class="BmlToolbar-button" data-original-title="" title="">
<i class="Icon Icon--16 Icon--underline"></i>
</span>
<span class="BmlToolbar-divider"></span>
<span data-toggle="tooltip" data-tooltip-content="@lang('forum.list')" data-topic-post-button="true" data-trigger="bml.list.bmltoolbar" class="BmlToolbar-button" data-original-title="" title="">
<i class="Icon Icon--16 Icon--list"></i>
</span>
<span data-toggle="tooltip" data-tooltip-content="@lang('forum.listItem')" data-topic-post-button="true" data-trigger="bml.listItem.bmltoolbar" class="BmlToolbar-button" data-original-title="" title="">
<i class="Icon Icon--16 Icon--list-item"></i>
</span>
<span class="BmlToolbar-divider"></span>
<span data-toggle="tooltip" data-tooltip-content="@lang('forum.quote')" data-topic-post-button="true" data-trigger="bml.quote.bmltoolbar" class="BmlToolbar-button" data-original-title="" title="">
<i class="Icon Icon--16 Icon--quote"></i>
</span>
<span data-toggle="tooltip" data-tooltip-content="@lang('forum.code')" data-topic-post-button="true" data-trigger="bml.code.bmltoolbar" class="BmlToolbar-button" data-original-title="" title="">
<i class="Icon Icon--16 Icon--code"></i>
</span>
</div>
</div>
<div class="PostForm-errors"></div>
</div>
<span class="TopicForm-link">
<a href="/code-of-conduct" class="TopicForm-link--conduct">@lang('forum.Code_of_Conduct')</a>
</span>

<div class="TopicForm-action--buttons">
<button type="submit" class="TopicForm-button TopicForm-button--reply" id="submit-button"><span class="Button-content">@lang('forum.TopicFormReply')</span></button>
<button type="button" data-topic-button="true" data-trigger="edit.topic.reply" class="TopicForm-button TopicForm-button--edit">
<span class="Button-content">@lang('forum.TopicFormEdit')</span></button>
</div>
</form>
@endif
</div>
</div>
</section>
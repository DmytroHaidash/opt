<div class="mt-6 hidden lg:flex justify-center">
    <!-- Sharingbutton Facebook -->
    <a class="resp-sharing-button__link" href="https://facebook.com/sharer/sharer.php?u={{url()->current()}}"
       target="_blank" rel="noopener" aria-label="{{__('shop.share')}} Facebook">
        <div class="resp-sharing-button resp-sharing-button--facebook resp-sharing-button--large">
            <div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/>
                </svg>
            </div>{{__('shop.share')}} Facebook
        </div>
    </a>

    <!-- Sharingbutton Twitter -->
    <a class="resp-sharing-button__link"
       href="https://twitter.com/intent/tweet/?text={{config('app.name')}}.&amp;url={{url()->current()}}"
       target="_blank" rel="noopener" aria-label="{{__('shop.share')}} Twitter">
        <div class="resp-sharing-button resp-sharing-button--twitter resp-sharing-button--large">
            <div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M23.44 4.83c-.8.37-1.5.38-2.22.02.93-.56.98-.96 1.32-2.02-.88.52-1.86.9-2.9 1.1-.82-.88-2-1.43-3.3-1.43-2.5 0-4.55 2.04-4.55 4.54 0 .36.03.7.1 1.04-3.77-.2-7.12-2-9.36-4.75-.4.67-.6 1.45-.6 2.3 0 1.56.8 2.95 2 3.77-.74-.03-1.44-.23-2.05-.57v.06c0 2.2 1.56 4.03 3.64 4.44-.67.2-1.37.2-2.06.08.58 1.8 2.26 3.12 4.25 3.16C5.78 18.1 3.37 18.74 1 18.46c2 1.3 4.4 2.04 6.97 2.04 8.35 0 12.92-6.92 12.92-12.93 0-.2 0-.4-.02-.6.9-.63 1.96-1.22 2.56-2.14z"/>
                </svg>
            </div>{{__('shop.share')}} Twitter
        </div>
    </a>

    <!-- Sharingbutton LinkedIn -->
    <a class="resp-sharing-button__link"
       href="https://www.linkedin.com/shareArticle?mini=true&amp;url={{url()->current()}}&amp;title={{config('app.name')}}.&amp;summary={{config('app.name')}}.&amp;source={{url()->current()}}"
       target="_blank" rel="noopener" aria-label="{{__('shop.share')}} LinkedIn">
        <div class="resp-sharing-button resp-sharing-button--linkedin resp-sharing-button--large">
            <div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M6.5 21.5h-5v-13h5v13zM4 6.5C2.5 6.5 1.5 5.3 1.5 4s1-2.4 2.5-2.4c1.6 0 2.5 1 2.6 2.5 0 1.4-1 2.5-2.6 2.5zm11.5 6c-1 0-2 1-2 2v7h-5v-13h5V10s1.6-1.5 4-1.5c3 0 5 2.2 5 6.3v6.7h-5v-7c0-1-1-2-2-2z"/>
                </svg>
            </div>{{__('shop.share')}} LinkedIn
        </div>
    </a>
    <!-- Sharingbutton WhatsApp -->
{{--<a class="resp-sharing-button__link"
   href="whatsapp://send?text={{url()->current()}}"
   target="_blank" rel="noopener" aria-label="{{__('shop.share')}} WhatsApp">
    <div class="resp-sharing-button resp-sharing-button--whatsapp resp-sharing-button--large"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20.1 3.9C17.9 1.7 15 .5 12 .5 5.8.5.7 5.6.7 11.9c0 2 .5 3.9 1.5 5.6L.6 23.4l6-1.6c1.6.9 3.5 1.3 5.4 1.3 6.3 0 11.4-5.1 11.4-11.4-.1-2.8-1.2-5.7-3.3-7.8zM12 21.4c-1.7 0-3.3-.5-4.8-1.3l-.4-.2-3.5 1 1-3.4L4 17c-1-1.5-1.4-3.2-1.4-5.1 0-5.2 4.2-9.4 9.4-9.4 2.5 0 4.9 1 6.7 2.8 1.8 1.8 2.8 4.2 2.8 6.7-.1 5.2-4.3 9.4-9.5 9.4zm5.1-7.1c-.3-.1-1.7-.9-1.9-1-.3-.1-.5-.1-.7.1-.2.3-.8 1-.9 1.1-.2.2-.3.2-.6.1s-1.2-.5-2.3-1.4c-.9-.8-1.4-1.7-1.6-2-.2-.3 0-.5.1-.6s.3-.3.4-.5c.2-.1.3-.3.4-.5.1-.2 0-.4 0-.5C10 9 9.3 7.6 9 7c-.1-.4-.4-.3-.5-.3h-.6s-.4.1-.7.3c-.3.3-1 1-1 2.4s1 2.8 1.1 3c.1.2 2 3.1 4.9 4.3.7.3 1.2.5 1.6.6.7.2 1.3.2 1.8.1.6-.1 1.7-.7 1.9-1.3.2-.7.2-1.2.2-1.3-.1-.3-.3-.4-.6-.5z"/></svg>
        </div>{{__('shop.share')}} WhatsApp</div>
</a>--}}

<!-- Sharingbutton Telegram -->
    <a class="resp-sharing-button__link"
       href="https://telegram.me/share/url?text={{config('app.name')}}.&amp;url={{url()->current()}}" target="_blank"
       rel="noopener" aria-label="{{__('shop.share')}} Telegram">
        <div class="resp-sharing-button resp-sharing-button--telegram resp-sharing-button--large">
            <div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M.707 8.475C.275 8.64 0 9.508 0 9.508s.284.867.718 1.03l5.09 1.897 1.986 6.38a1.102 1.102 0 0 0 1.75.527l2.96-2.41a.405.405 0 0 1 .494-.013l5.34 3.87a1.1 1.1 0 0 0 1.046.135 1.1 1.1 0 0 0 .682-.803l3.91-18.795A1.102 1.102 0 0 0 22.5.075L.706 8.475z"/>
                </svg>
            </div>{{__('shop.share')}} Telegram
        </div>
    </a>
    <a class="resp-sharing-button__link" href="viber://forward?text={{url()->current()}}" target="_blank" rel="noopener"
       aria-label="{{__('shop.share')}} Viber">
        <div class="resp-sharing-button resp-sharing-button--viber resp-sharing-button--large">
            <div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                    <path
                        d="M21.176 27c-.208-.062-.618-.13-.987-.303-6.476-3.02-11.18-7.972-13.853-15.082-.897-2.383.04-4.396 2.298-5.22.405-.147.802-.157 1.2.002.964.383 3.404 4.022 3.458 5.11.042.835-.48 1.287-1 1.67-.983.722-.988 1.638-.568 2.66.948 2.308 2.567 3.895 4.663 4.925.76.374 1.488.337 2.007-.515.925-1.518 2.06-1.445 3.3-.502.62.473 1.253.936 1.844 1.45.8.702 1.816 1.285 1.336 2.754-.5 1.527-2.226 3.066-3.7 3.05zm-4.76-20.986c4.546.166 8.46 4.677 8.406 9.543-.005.478.153 1.185-.504 1.172-.628-.015-.464-.733-.52-1.21-.603-5.167-2.786-7.606-7.52-8.394-.392-.066-.99.026-.96-.535.044-.833.754-.523 1.097-.576zm6.072 8.672c-.045.356.147.968-.385 1.056-.72.118-.58-.595-.65-1.053-.48-3.144-1.5-4.297-4.423-5.005-.43-.105-1.1-.032-.99-.75.108-.685.71-.452 1.164-.393 2.92.38 5.307 3.126 5.284 6.144zm-2.222-.573c.013.398-.026.818-.46.874-.314.04-.52-.245-.553-.597-.12-1.296-.75-2.062-1.95-2.27-.36-.063-.712-.19-.544-.715.11-.352.408-.387.712-.396 1.297-.036 2.815 1.647 2.794 3.103z"
                        fill-rule="evenodd"></path>
                </svg>
            </div>{{__('shop.share')}} Viber
        </div>
    </a>

</div>

<div class="mt-6 flex lg:hidden justify-center">
    <a class="resp-sharing-button__link" href="https://facebook.com/sharer/sharer.php?u={{url()->current()}}"
       target="_blank" rel="noopener" aria-label="{{__('shop.share')}} Facebook">
        <div class="resp-sharing-button resp-sharing-button--facebook resp-sharing-button--large">
            <div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid ">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/>
                </svg>
            </div>
        </div>
    </a>

    <a class="resp-sharing-button__link"
       href="https://twitter.com/intent/tweet/?text={{config('app.name')}}.&amp;url={{url()->current()}}"
       target="_blank" rel="noopener" aria-label="{{__('shop.share')}} Twitter">
        <div class="resp-sharing-button resp-sharing-button--twitter resp-sharing-button--large">
            <div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M23.44 4.83c-.8.37-1.5.38-2.22.02.93-.56.98-.96 1.32-2.02-.88.52-1.86.9-2.9 1.1-.82-.88-2-1.43-3.3-1.43-2.5 0-4.55 2.04-4.55 4.54 0 .36.03.7.1 1.04-3.77-.2-7.12-2-9.36-4.75-.4.67-.6 1.45-.6 2.3 0 1.56.8 2.95 2 3.77-.74-.03-1.44-.23-2.05-.57v.06c0 2.2 1.56 4.03 3.64 4.44-.67.2-1.37.2-2.06.08.58 1.8 2.26 3.12 4.25 3.16C5.78 18.1 3.37 18.74 1 18.46c2 1.3 4.4 2.04 6.97 2.04 8.35 0 12.92-6.92 12.92-12.93 0-.2 0-.4-.02-.6.9-.63 1.96-1.22 2.56-2.14z"/>
                </svg>
            </div>
        </div>
    </a>
    <a class="resp-sharing-button__link"
       href="https://www.linkedin.com/shareArticle?mini=true&amp;url={{url()->current()}}&amp;title={{config('app.name')}}.&amp;summary={{config('app.name')}}.&amp;source={{url()->current()}}"
       target="_blank" rel="noopener" aria-label="{{__('shop.share')}} LinkedIn">
        <div class="resp-sharing-button resp-sharing-button--linkedin resp-sharing-button--large">
            <div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M6.5 21.5h-5v-13h5v13zM4 6.5C2.5 6.5 1.5 5.3 1.5 4s1-2.4 2.5-2.4c1.6 0 2.5 1 2.6 2.5 0 1.4-1 2.5-2.6 2.5zm11.5 6c-1 0-2 1-2 2v7h-5v-13h5V10s1.6-1.5 4-1.5c3 0 5 2.2 5 6.3v6.7h-5v-7c0-1-1-2-2-2z"/>
                </svg>
            </div>
        </div>
    </a>

    <a class="resp-sharing-button__link"
       href="https://telegram.me/share/url?text={{config('app.name')}}.&amp;url={{url()->current()}}" target="_blank"
       rel="noopener" aria-label="{{__('shop.share')}} Telegram">
        <div class="resp-sharing-button resp-sharing-button--telegram resp-sharing-button--large">
            <div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M.707 8.475C.275 8.64 0 9.508 0 9.508s.284.867.718 1.03l5.09 1.897 1.986 6.38a1.102 1.102 0 0 0 1.75.527l2.96-2.41a.405.405 0 0 1 .494-.013l5.34 3.87a1.1 1.1 0 0 0 1.046.135 1.1 1.1 0 0 0 .682-.803l3.91-18.795A1.102 1.102 0 0 0 22.5.075L.706 8.475z"/>
                </svg>
            </div>
        </div>
    </a>

    <a class="resp-sharing-button__link" href="viber://forward?text={{url()->current()}}" target="_blank" rel="noopener"
       aria-label="{{__('shop.share')}} Viber">
        <div class="resp-sharing-button resp-sharing-button--viber resp-sharing-button--large">
            <div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                    <path
                        d="M21.176 27c-.208-.062-.618-.13-.987-.303-6.476-3.02-11.18-7.972-13.853-15.082-.897-2.383.04-4.396 2.298-5.22.405-.147.802-.157 1.2.002.964.383 3.404 4.022 3.458 5.11.042.835-.48 1.287-1 1.67-.983.722-.988 1.638-.568 2.66.948 2.308 2.567 3.895 4.663 4.925.76.374 1.488.337 2.007-.515.925-1.518 2.06-1.445 3.3-.502.62.473 1.253.936 1.844 1.45.8.702 1.816 1.285 1.336 2.754-.5 1.527-2.226 3.066-3.7 3.05zm-4.76-20.986c4.546.166 8.46 4.677 8.406 9.543-.005.478.153 1.185-.504 1.172-.628-.015-.464-.733-.52-1.21-.603-5.167-2.786-7.606-7.52-8.394-.392-.066-.99.026-.96-.535.044-.833.754-.523 1.097-.576zm6.072 8.672c-.045.356.147.968-.385 1.056-.72.118-.58-.595-.65-1.053-.48-3.144-1.5-4.297-4.423-5.005-.43-.105-1.1-.032-.99-.75.108-.685.71-.452 1.164-.393 2.92.38 5.307 3.126 5.284 6.144zm-2.222-.573c.013.398-.026.818-.46.874-.314.04-.52-.245-.553-.597-.12-1.296-.75-2.062-1.95-2.27-.36-.063-.712-.19-.544-.715.11-.352.408-.387.712-.396 1.297-.036 2.815 1.647 2.794 3.103z"
                        fill-rule="evenodd"></path>
                </svg>
            </div>
        </div>
    </a>

</div>

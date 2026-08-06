<a {{ $attributes }}
   style="display:block; padding:0.5rem 1rem; font-size:0.875rem; color:#94A3B8; transition:all 0.15s; font-family:inherit;"
   onmouseover="this.style.color='#E2E8F0'; this.style.background='rgba(79,142,247,0.08)';"
   onmouseout="this.style.color='#94A3B8'; this.style.background='';">
    {{ $slot }}
</a>

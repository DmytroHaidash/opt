<template>
    <svg class="fill-current" width="48" height="48" xmlns="http://www.w3.org/2000/svg" style="margin: auto; background: none; display: block; shape-rendering: auto;" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
        <circle cx="50" cy="50" r="40" stroke-width="8" :stroke="color" stroke-dasharray="62.83185307179586 62.83185307179586" fill="none" stroke-linecap="round" transform="rotate(326.682 50.0001 50)">
            <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" keyTimes="0;1" values="0 50 50;360 50 50"></animateTransform>
        </circle>
    </svg>
</template>

<script>
    export default {
        props: {
            color: {
                type: String,
                default: '#a0aec0'
            }
        }
    }
</script>

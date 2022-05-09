<?php
locked();
?>
<audio class="player" src="https://www.codepunker.com/resources/audio-sync-with-text/10bears.mp3" controls></audio>

<!-- <video class="player" src="http://caiman.graodemilho.com.br/wp-content/uploads/2019/03/Video_SPLASH_v3_leve.mp4" controls></video> -->

<div class="lyrics" style="display: none">
    0.125 | There were
    0.485 | 10 in his bed
    1.685 | and the little
    2.245 | one said
    2.985 | Roll over!
    5.405 | 
</div>

<script>
    const player = document.querySelector('.player')
const lyrics = document.querySelector('.lyrics')
const lines = lyrics.textContent.trim().split('\n')

lyrics.removeAttribute('style')
lyrics.innerText = ''

let syncData = []

lines.map((line, index) => {
    const [time, text] = line.trim().split('|')
    syncData.push({'start': time.trim(), 'text': text.trim()})
})

player.addEventListener('timeupdate', () => {
    syncData.forEach((item) => {
        console.log(item)
        if (player.currentTime >= item.start) lyrics.innerText = item.text
    })
})
</script>
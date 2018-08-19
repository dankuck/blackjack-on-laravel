<template>
    <div :style="`background: url('/card-deck.gif') ${this.cardLeft}px ${this.cardTop}px`" class="card"></div>
</template>

<script>
export default {
    props: ['card'],
    data() {
        // The sprite card-deck.gif is a map of cards with width 81px and 
        // height 117px.
        // Though they are a little off, so there are adjustments in cardTop
        // and cardLeft.
        return {
            width: 81,
            height: 117,
        };
    },
    computed: {
        cardLeft() {
            return this.cardFacePosition * -this.width - 1;
        },
        cardTop() {
            return this.cardSuitPosition * -this.height - 2;
        },
        cardFacePosition() {
            if (this.card == 'BACK') {
                return 0;
            }
            switch (this.cardFace) {
                case '2': return 0;
                case '3': return 1;
                case '4': return 2;
                case '5': return 3;
                case '6': return 4;
                case '7': return 5;
                case '8': return 6;
                case '9': return 7;
                case '10': return 8;
                case 'J': return 9;
                case 'Q': return 10;
                case 'K': return 11;
                case 'A': return 12;
                default:
                    throw `Unknown cardFace: ${this.cardFace}`;
            }
        },
        cardSuitPosition() {
            if (this.card == 'BACK') {
                return 4;
            }
            switch (this.cardSuit) {
                case 'H': return 0;
                case 'D': return 1;
                case 'C': return 2;
                case 'S': return 3;
                default:
                    throw `Unknown cardSuite: ${this.cardSuit}`;
            }
        },
        cardSuit() {
            return this.card.substr(-1);
        },
        cardFace() {
            return this.card.substr(0, this.card.length - 1);
        },
    },
}
</script>

<style>
.card {
    width: 81px;
    height: 117px;
    display: inline-block;
}
</style>

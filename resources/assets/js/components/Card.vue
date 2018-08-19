<template>
    <div :style="`background: url('/card-deck.gif') ${this.cardLeft}px ${this.cardTop}px`" class="card"></div>
</template>

<script>
export default {
    props: ['card'],
    data() {
        return {
            width: 81,
            height: 117,
        };
    },
    computed: {
        style() {
            return ;
        },
        cardLeft() {
            switch (this.cardFace) {
                case '2': return 0 * -this.width;
                case '3': return 1 * -this.width;
                case '4': return 2 * -this.width;
                case '5': return 3 * -this.width;
                case '6': return 4 * -this.width;
                case '7': return 5 * -this.width;
                case '8': return 6 * -this.width;
                case '9': return 7 * -this.width;
                case '10': return 8 * -this.width;
                case 'J': return 9 * -this.width;
                case 'Q': return 10 * -this.width;
                case 'K': return 11 * -this.width;
                case 'A': return 12 * -this.width;
                default:
                    throw `Unknown cardFace: ${this.cardFace}`;
            }
        },
        cardTop() {
            switch (this.cardSuit) {
                case 'H': return 0 * -this.height;
                case 'D': return 1 * -this.height;
                case 'C': return 2 * -this.height;
                case 'S': return 3 * -this.height;
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

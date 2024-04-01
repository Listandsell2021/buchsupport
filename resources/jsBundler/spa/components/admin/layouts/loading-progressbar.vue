<template>
    <div>
        <div :class="{'loading-container': true, loading: isLoading, visible: isVisible}">
            <div class="loader" :style="{ width: progress + '%' }">
                <div class="light"></div>
            </div>
            <div class="glow"></div>
        </div>
    </div>
</template>

<script>
import random from 'lodash/random';

// Assume that loading will complete under this amount of time.
const defaultDuration = 1000

// How frequently to update
const defaultInterval = 50

// 0 - 1. Add some variation to how much the bar will grow at each interval
const variation = 0.1

// 0 - 100. Where the progress bar should start from.
const startingPoint = 0

// Limiting how far the progress bar will get to before loading is complete
const endingPoint = 100

export default {

    data: () => ({
        isLoading: true, // Once loading is done, start fading away
        isVisible: false, // Once animate finish, set display: none
        progress: startingPoint,
        timeoutId: undefined,
    }),

    mounted() {
        this.start();
    },

    unmounted() {
        this.stop();
    },

    methods: {
        start() {
            this.isLoading = true
            this.isVisible = true
            this.progress = startingPoint
            this.loop()
        },

        loop() {
            if (this.timeoutId) {
                clearTimeout(this.timeoutId)
            }
            if (this.progress >= endingPoint) {
                return
            }
            const size = (endingPoint - startingPoint) / (defaultDuration / defaultInterval)
            const p = Math.round(this.progress + random(size * (1 - variation), size * (1 + variation)))
            this.progress = Math.min(p, endingPoint)
            this.timeoutId = setTimeout(
                this.loop,
                random(defaultInterval * (1 - variation), defaultInterval * (1 + variation))
            )
        },

        stop() {
            this.isLoading = false
            this.progress = 100
            clearTimeout(this.timeoutId)
            const self = this
            setTimeout(() => {
                if (!self.isLoading) {
                    self.isVisible = false
                }
            }, 200)
        },
    },
}
</script>


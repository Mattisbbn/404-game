<template>
  <div class="dice-container">
    <div class="scene">
      <div
        class="cube"
        :class="{ 'cube-rolling': isRolling }"
        :style="{ transform: cubeTransform }"
      >
        <div class="core-face core-1"></div>
        <div class="core-face core-2"></div>
        <div class="core-face core-3"></div>
        <div class="core-face core-4"></div>
        <div class="core-face core-5"></div>
        <div class="core-face core-6"></div>

        <div class="face face-1"><div class="dot"></div></div>
        <div class="face face-2"><div class="dot"></div><div class="dot"></div></div>
        <div class="face face-3"><div class="dot"></div><div class="dot"></div><div class="dot"></div></div>
        <div class="face face-4">
          <div class="dot"></div>
          <div class="dot"></div>
          <div class="dot"></div>
          <div class="dot"></div>
        </div>
        <div class="face face-5">
          <div class="dot"></div>
          <div class="dot"></div>
          <div class="dot"></div>
          <div class="dot"></div>
          <div class="dot"></div>
        </div>

        <div class="face face-6">
          <img
            v-if="customImage"
            :src="customImage"
            class="custom-img"
            alt="Face personnalisée"
          />
          <i v-else class="fas fa-star default-icon"></i>
        </div>
      </div>
      <div class="shadow-platform"></div>
    </div>

    <button class="roll-button" type="button" @click="rollDice">
      <i class="fas fa-dice"></i>
      <span>Lancer le dé (5s)</span>
    </button>

    <p
      class="result-text"
      :class="{
        visible: isResultVisible,
        'text-custom-highlight': isCustomResult,
      }"
    >
      {{ resultLabel }}
    </p>
  </div>
</template>

<script setup>
import { computed, onBeforeUnmount, ref } from 'vue';

const props = defineProps({
  customImage: {
    type: String,
    default: '',
  },
});

const rotation = ref({ x: 0, y: 0 });
const isRolling = ref(false);
const isResultVisible = ref(false);
const isCustomResult = ref(false);
const resultLabel = ref('Résultat : -');

const faces = {
  1: { x: 0, y: 0 },
  2: { x: 90, y: 0 },
  3: { x: 0, y: -90 },
  4: { x: 0, y: 90 },
  5: { x: -90, y: 0 },
  6: { x: 0, y: 180 },
};

const cubeTransform = computed(
  () => `translateZ(-60px) rotateX(${rotation.value.x}deg) rotateY(${rotation.value.y}deg)`,
);

let rollTimeout;

const rollDice = () => {
  if (isRolling.value) {
    return;
  }

  isRolling.value = true;
  isResultVisible.value = false;

  const result = Math.floor(Math.random() * 6) + 1;
  const target = faces[result];
  const extraSpinsX = (Math.floor(Math.random() * 3) + 2) * 360;
  const extraSpinsY = (Math.floor(Math.random() * 3) + 2) * 360;

  rotation.value = {
    x: rotation.value.x + (360 - (rotation.value.x % 360)) + target.x + extraSpinsX,
    y: rotation.value.y + (360 - (rotation.value.y % 360)) + target.y + extraSpinsY,
  };

  rollTimeout = window.setTimeout(() => {
    isRolling.value = false;
    isCustomResult.value = result === 6;
    resultLabel.value = result === 6
      ? 'Résultat : 6 (Face personnalisée !)'
      : `Résultat : ${result}`;
    isResultVisible.value = true;
  }, 5000);
};

onBeforeUnmount(() => {
  window.clearTimeout(rollTimeout);
});
</script>

<style scoped>
.dice-container {
  --dice-size: 120px;
  --core-size: 118px;
  --dice-color: #f3f4f6;
  --dot-color: #1f2937;
  --anim-duration: 5s;
  width: fit-content;
  margin: 0 auto;
  padding: 1rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1.5rem;
  color: #1f2937;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.scene {
  width: var(--dice-size);
  height: var(--dice-size);
  perspective: 800px;
}

.cube {
  width: 100%;
  height: 100%;
  position: relative;
  transform-style: preserve-3d;
  transition: transform var(--anim-duration) cubic-bezier(0.15, 0.9, 0.3, 1.1);
}

.core-face {
  position: absolute;
  width: var(--core-size);
  height: var(--core-size);
  background: var(--dice-color);
  top: 50%;
  left: 50%;
  transform-origin: center;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

.core-1 {
  transform: translate(-50%, -50%) rotateY(0deg) translateZ(calc(var(--core-size) / 2));
}

.core-2 {
  transform: translate(-50%, -50%) rotateX(-90deg) translateZ(calc(var(--core-size) / 2));
}

.core-3 {
  transform: translate(-50%, -50%) rotateY(90deg) translateZ(calc(var(--core-size) / 2));
}

.core-4 {
  transform: translate(-50%, -50%) rotateY(-90deg) translateZ(calc(var(--core-size) / 2));
}

.core-5 {
  transform: translate(-50%, -50%) rotateX(90deg) translateZ(calc(var(--core-size) / 2));
}

.core-6 {
  transform: translate(-50%, -50%) rotateY(180deg) translateZ(calc(var(--core-size) / 2));
}

.face {
  position: absolute;
  width: var(--dice-size);
  height: var(--dice-size);
  background: var(--dice-color);
  border: 1px solid #d1d5db;
  border-radius: 12px;
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  grid-template-rows: repeat(3, 1fr);
  padding: 10px;
  backface-visibility: hidden;
  transform-style: preserve-3d;
  box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.03);
}

.dot {
  width: 20px;
  height: 20px;
  background-color: var(--dot-color);
  border-radius: 50%;
  place-self: center;
  box-shadow: inset 0 3px 3px rgba(0, 0, 0, 0.15);
}

.face-1 {
  transform: rotateY(0deg) translateZ(calc(var(--dice-size) / 2));
}

.face-2 {
  transform: rotateX(-90deg) translateZ(calc(var(--dice-size) / 2));
}

.face-3 {
  transform: rotateY(90deg) translateZ(calc(var(--dice-size) / 2));
}

.face-4 {
  transform: rotateY(-90deg) translateZ(calc(var(--dice-size) / 2));
}

.face-5 {
  transform: rotateX(90deg) translateZ(calc(var(--dice-size) / 2));
}

.face-6 {
  transform: rotateY(180deg) translateZ(calc(var(--dice-size) / 2));
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0;
  overflow: hidden;
  background: #fff;
}

.face-1 .dot:nth-child(1) {
  grid-area: 2 / 2;
}

.face-2 .dot:nth-child(1) {
  grid-area: 1 / 1;
}

.face-2 .dot:nth-child(2) {
  grid-area: 3 / 3;
}

.face-3 .dot:nth-child(1) {
  grid-area: 1 / 1;
}

.face-3 .dot:nth-child(2) {
  grid-area: 2 / 2;
}

.face-3 .dot:nth-child(3) {
  grid-area: 3 / 3;
}

.face-4 .dot:nth-child(1) {
  grid-area: 1 / 1;
}

.face-4 .dot:nth-child(2) {
  grid-area: 1 / 3;
}

.face-4 .dot:nth-child(3) {
  grid-area: 3 / 1;
}

.face-4 .dot:nth-child(4) {
  grid-area: 3 / 3;
}

.face-5 .dot:nth-child(1) {
  grid-area: 1 / 1;
}

.face-5 .dot:nth-child(2) {
  grid-area: 1 / 3;
}

.face-5 .dot:nth-child(3) {
  grid-area: 2 / 2;
}

.face-5 .dot:nth-child(4) {
  grid-area: 3 / 1;
}

.face-5 .dot:nth-child(5) {
  grid-area: 3 / 3;
}

.custom-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 10px;
}

.default-icon {
  font-size: 3rem;
  color: #d1d5db;
}

.shadow-platform {
  width: 80px;
  height: 20px;
  background: rgba(0, 0, 0, 0.1);
  border-radius: 50%;
  margin: 3rem auto 0;
  filter: blur(8px);
  transition: all 0.5s ease;
}

.cube-rolling + .shadow-platform {
  transform: scale(0.6);
  opacity: 0.5;
}

.roll-button {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  background-color: #1f2937;
  color: #fff;
  border: none;
  border-radius: 12px;
  padding: 0.85rem 1.5rem;
  font-weight: 600;
  cursor: pointer;
  transition: transform 0.15s ease, background-color 0.2s ease;
  box-shadow: 0 12px 24px rgba(15, 23, 42, 0.2);
}

.roll-button:active {
  transform: scale(0.96);
}

.roll-button:hover {
  background-color: #334155;
}

.result-text {
  min-height: 1.5rem;
  font-weight: 600;
  color: #475569;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.result-text.visible {
  opacity: 1;
}

.text-custom-highlight {
  color: #4f46e5;
}
</style>


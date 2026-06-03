import * as faceapi from 'face-api.js';

const MODEL_URL = 'https://cdn.jsdelivr.net/gh/justadudewhohacks/face-api.js@master/weights';
let modelsPromise = null;
let activeStream = null;

function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content || '';
}

function setStatus(element, message, type = 'info') {
    if (!element) return;

    const classes = {
        info: 'border-blue-100 bg-blue-50 text-blue-700',
        success: 'border-green-200 bg-green-50 text-green-700',
        error: 'border-red-200 bg-red-50 text-red-700',
    };

    element.className = `rounded-lg border px-4 py-3 text-sm ${classes[type] || classes.info}`;
    element.textContent = message;
}

async function loadModels(status) {
    if (!modelsPromise) {
        setStatus(status, 'Đang tải model nhận diện khuôn mặt...', 'info');
        modelsPromise = Promise.all([
            faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL),
            faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
            faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL),
        ]);
    }

    await modelsPromise;
}

async function startCamera(video, status) {
    await loadModels(status);

    if (activeStream) {
        activeStream.getTracks().forEach((track) => track.stop());
    }

    activeStream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' }, audio: false });
    video.srcObject = activeStream;

    await new Promise((resolve) => {
        video.onloadedmetadata = () => resolve();
    });

    await video.play();
    setStatus(status, 'Webcam đã sẵn sàng. Giữ một khuôn mặt trong khung hình rồi bấm thao tác.', 'success');
}

async function readDescriptor(video) {
    const detections = await faceapi
        .detectAllFaces(video, new faceapi.TinyFaceDetectorOptions({ inputSize: 224, scoreThreshold: 0.5 }))
        .withFaceLandmarks()
        .withFaceDescriptors();

    if (detections.length === 0) {
        throw new Error('Không thấy khuôn mặt. Vui lòng nhìn thẳng camera và thử lại.');
    }

    if (detections.length > 1) {
        throw new Error('Phát hiện nhiều khuôn mặt. Chỉ để một người trong khung hình.');
    }

    return Array.from(detections[0].descriptor);
}

async function postDescriptor(url, descriptor) {
    const response = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken(),
        },
        credentials: 'same-origin',
        body: JSON.stringify({ descriptor }),
    });

    const data = await response.json().catch(() => ({}));

    if (!response.ok) {
        throw new Error(data.message || 'Không xử lý được descriptor khuôn mặt.');
    }

    return data;
}

function bindFaceBox(root) {
    const video = root.querySelector('[data-face-video]');
    const status = root.querySelector('[data-face-status]');
    const startButton = root.querySelector('[data-face-start]');
    const captureButton = root.querySelector('[data-face-capture]');
    const url = root.dataset.faceSubmitUrl;
    const mode = root.dataset.faceMode;

    if (!video || !status || !startButton || !captureButton || !url) return;

    startButton.addEventListener('click', async () => {
        try {
            startButton.disabled = true;
            await startCamera(video, status);
            captureButton.disabled = false;
        } catch (error) {
            startButton.disabled = false;
            setStatus(status, error.message || 'Không mở được webcam.', 'error');
        }
    });

    captureButton.addEventListener('click', async () => {
        try {
            captureButton.disabled = true;
            setStatus(status, 'Đang đọc descriptor...', 'info');
            const descriptor = await readDescriptor(video);
            const data = await postDescriptor(url, descriptor);

            setStatus(status, data.message || 'Thành công.', 'success');

            if (mode === 'login' && data.redirect) {
                window.location.href = data.redirect;
            }
        } catch (error) {
            setStatus(status, error.message || 'Thao tác thất bại.', 'error');
        } finally {
            captureButton.disabled = false;
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-face-mode]').forEach(bindFaceBox);

    document.querySelectorAll('[data-face-open-login]').forEach((button) => {
        button.addEventListener('click', () => {
            const target = document.querySelector(button.dataset.faceOpenLogin);
            target?.classList.remove('hidden');
        });
    });

    document.querySelectorAll('[data-face-close-login]').forEach((button) => {
        button.addEventListener('click', () => {
            const target = button.closest('[data-face-login-modal]');
            target?.classList.add('hidden');
        });
    });
});

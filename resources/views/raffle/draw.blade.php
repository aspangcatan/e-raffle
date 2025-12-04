@extends('layouts.app')

@section('content')
    <!-- Christmas Stage Curtains -->
    <div class="curtain-container">
        <div class="curtain curtain-left"></div>
        <div class="curtain curtain-right"></div>
    </div>

    <!-- Snowflakes -->
    <div class="snowflakes" aria-hidden="true">
        @for ($i = 0; $i < 20; $i++)
            <div class="snowflake">❅</div>
        @endfor
    </div>

    <div class="christmas-wrapper">
        <div class="container d-flex flex-column justify-content-center align-items-center" style="min-height: 70vh; text-align: center; position: relative; z-index: 10;">
            <h1 class="christmas-title mb-4">Christmas Raffle Draw 🎄</h1>
            <p class="christmas-subtitle mb-4">✨ Draw Winner by Sequence Number ✨</p>

            <div id="picker" class="d-flex justify-content-center gap-4 my-4">
                @for ($i = 0; $i < 5; $i++)
                    <div class="digit-square" id="digit-{{ $i }}">0</div>
                @endfor
            </div>

            <button id="spinBtn" class="btn-christmas btn-lg px-5 py-3">
                <span>🎁 SPIN 🎁</span>
            </button>

            <div id="winnerName" class="winner-card mt-4 d-none"></div>
        </div>

        <!-- Christmas Gifts at Bottom -->
        <div class="gifts-container">
            <div class="gift gift-1">
                <div class="gift-box" style="background: #c41e3a;"></div>
                <div class="gift-ribbon"></div>
                <div class="gift-bow"></div>
            </div>
            <div class="gift gift-2">
                <div class="gift-box" style="background: #0f8a5f;"></div>
                <div class="gift-ribbon"></div>
                <div class="gift-bow"></div>
            </div>
            <div class="gift gift-3">
                <div class="gift-box" style="background: #ffd700;"></div>
                <div class="gift-ribbon"></div>
                <div class="gift-bow"></div>
            </div>
            <div class="gift gift-4">
                <div class="gift-box" style="background: #c41e3a;"></div>
                <div class="gift-ribbon"></div>
                <div class="gift-bow"></div>
            </div>
            <div class="gift gift-5">
                <div class="gift-box" style="background: #0f8a5f;"></div>
                <div class="gift-ribbon"></div>
                <div class="gift-bow"></div>
            </div>
        </div>
    </div>

    <style>
        body {
            background: linear-gradient(135deg, #1a472a 0%, #2d5a3d 50%, #1a472a 100%);
            overflow-x: hidden;
        }

        .christmas-wrapper {
            position: relative;
            min-height: 100vh;
        }

        /* Curtains */
        .curtain-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 200px;
            z-index: 100;
            pointer-events: none;
        }

        .curtain {
            position: absolute;
            top: 0;
            width: 50%;
            height: 100%;
            background: linear-gradient(to bottom, #8b0000 0%, #a00000 50%, #8b0000 100%);
            box-shadow: inset 0 0 30px rgba(0,0,0,0.5);
        }

        .curtain::before {
            content: '';
            position: absolute;
            top: 0;
            width: 100%;
            height: 20px;
            background: #ffd700;
            box-shadow: 0 2px 10px rgba(255,215,0,0.5);
        }

        .curtain::after {
            content: '';
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 100%;
            background: repeating-linear-gradient(
                90deg,
                transparent,
                transparent 40px,
                rgba(0,0,0,0.1) 40px,
                rgba(0,0,0,0.1) 80px
            );
        }

        .curtain-left {
            left: 0;
            border-radius: 0 0 50px 0;
        }

        .curtain-right {
            right: 0;
            border-radius: 0 0 0 50px;
        }

        /* Christmas Title */
        .christmas-title {
            font-size: 3.5rem;
            font-weight: 800;
            color: #fff;
            text-shadow: 
                0 0 10px rgba(255,215,0,0.8),
                0 0 20px rgba(255,215,0,0.6),
                2px 2px 4px rgba(0,0,0,0.5);
            margin-top: 80px;
            animation: glow 2s ease-in-out infinite alternate;
        }

        .christmas-subtitle {
            font-size: 1.5rem;
            color: #ffd700;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
            font-weight: 600;
        }

        @keyframes glow {
            from {
                text-shadow: 
                    0 0 10px rgba(255,215,0,0.8),
                    0 0 20px rgba(255,215,0,0.6),
                    2px 2px 4px rgba(0,0,0,0.5);
            }
            to {
                text-shadow: 
                    0 0 20px rgba(255,215,0,1),
                    0 0 30px rgba(255,215,0,0.8),
                    2px 2px 4px rgba(0,0,0,0.5);
            }
        }

        /* Digit Squares - Christmas themed */
        .digit-square {
            width: 90px;
            height: 120px;
            border-radius: 16px;
            background: linear-gradient(135deg, #c41e3a 0%, #a01729 100%);
            border: 4px solid #ffd700;
            color: white;
            font-size: 72px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            user-select: none;
            box-shadow: 
                0 6px 12px rgba(0, 0, 0, 0.4),
                0 0 20px rgba(255, 215, 0, 0.3),
                inset 0 1px 0 rgba(255,255,255,0.2);
            font-family: monospace;
            transition: all 0.3s ease;
            position: relative;
        }

        .digit-square::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #ffd700, #ffed4e, #ffd700);
            border-radius: 16px;
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .digit-square:hover {
            background: linear-gradient(135deg, #0f8a5f 0%, #0d7550 100%);
            transform: translateY(-5px);
            box-shadow: 
                0 10px 20px rgba(0, 0, 0, 0.5),
                0 0 30px rgba(255, 215, 0, 0.5);
        }

        .digit-square:hover::before {
            opacity: 1;
        }

        /* Christmas Button */
        .btn-christmas {
            background: linear-gradient(135deg, #c41e3a 0%, #a01729 100%);
            border: 3px solid #ffd700;
            color: white;
            font-size: 1.8rem;
            font-weight: 700;
            border-radius: 50px;
            box-shadow: 
                0 8px 15px rgba(0,0,0,0.3),
                0 0 20px rgba(255,215,0,0.4);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-christmas::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .btn-christmas:hover {
            background: linear-gradient(135deg, #0f8a5f 0%, #0d7550 100%);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 
                0 12px 25px rgba(0,0,0,0.4),
                0 0 30px rgba(255,215,0,0.6);
        }

        .btn-christmas:hover::before {
            left: 100%;
        }

        .btn-christmas:active {
            transform: translateY(-1px) scale(1.02);
        }

        .btn-christmas:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Winner Card */
        .winner-card {
            background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
            color: #1a472a;
            font-size: 1.8rem;
            font-weight: 700;
            min-width: 400px;
            padding: 25px;
            border-radius: 20px;
            border: 4px solid #c41e3a;
            box-shadow: 
                0 10px 30px rgba(0,0,0,0.4),
                0 0 40px rgba(255,215,0,0.6),
                inset 0 2px 0 rgba(255,255,255,0.5);
            animation: winnerPulse 1s ease-in-out infinite alternate;
        }

        @keyframes winnerPulse {
            from {
                box-shadow: 
                    0 10px 30px rgba(0,0,0,0.4),
                    0 0 40px rgba(255,215,0,0.6),
                    inset 0 2px 0 rgba(255,255,255,0.5);
            }
            to {
                box-shadow: 
                    0 10px 30px rgba(0,0,0,0.4),
                    0 0 60px rgba(255,215,0,0.9),
                    inset 0 2px 0 rgba(255,255,255,0.5);
            }
        }

        /* Snowflakes */
        .snowflakes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1000;
        }

        .snowflake {
            position: absolute;
            top: -10px;
            color: white;
            font-size: 1.5em;
            opacity: 0.8;
            animation: fall linear infinite;
            text-shadow: 0 0 5px rgba(255,255,255,0.8);
        }

        @keyframes fall {
            to {
                transform: translateY(100vh) rotate(360deg);
            }
        }

        @for ($i = 1; $i <= 20; $i++)
            .snowflake:nth-child({{ $i }}) {
                left: {{ $i * 5 }}%;
                animation-duration: {{ 8 + ($i % 5) }}s;
                animation-delay: {{ $i * 0.3 }}s;
                font-size: {{ 0.8 + ($i % 4) * 0.3 }}em;
            }
        @endfor

        /* Gift Boxes */
        .gifts-container {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 120px;
            display: flex;
            justify-content: space-around;
            align-items: flex-end;
            padding: 0 50px 20px;
            z-index: 50;
            pointer-events: none;
        }

        .gift {
            position: relative;
            animation: giftBounce 2s ease-in-out infinite;
        }

        .gift-1 { animation-delay: 0s; }
        .gift-2 { animation-delay: 0.2s; }
        .gift-3 { animation-delay: 0.4s; }
        .gift-4 { animation-delay: 0.6s; }
        .gift-5 { animation-delay: 0.8s; }

        @keyframes giftBounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .gift-box {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            box-shadow: 
                0 8px 15px rgba(0,0,0,0.3),
                inset 0 -5px 10px rgba(0,0,0,0.2),
                inset 0 5px 10px rgba(255,255,255,0.2);
            position: relative;
        }

        .gift-ribbon {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 15px;
            height: 100%;
            background: #ffd700;
            box-shadow: 0 0 10px rgba(255,215,0,0.5);
        }

        .gift-ribbon::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 15px;
            background: #ffd700;
            box-shadow: 0 0 10px rgba(255,215,0,0.5);
        }

        .gift-bow {
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 30px;
            background: #ffd700;
            border-radius: 50% 50% 0 0;
            box-shadow: 0 0 15px rgba(255,215,0,0.6);
        }

        .gift-bow::before,
        .gift-bow::after {
            content: '';
            position: absolute;
            top: 5px;
            width: 20px;
            height: 20px;
            background: #ffd700;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(255,215,0,0.5);
        }

        .gift-bow::before {
            left: -15px;
        }

        .gift-bow::after {
            right: -15px;
        }
    </style>

    <script>
        const spinBtn = document.getElementById('spinBtn');
        const winnerNameDiv = document.getElementById('winnerName');

        // Load audio files
        const drumRoll = new Audio('/sounds/drum_roll.mp3');
        const winnerSound = new Audio('/sounds/winner_fanfare.mp3');

        spinBtn.addEventListener('click', async () => {
            spinBtn.disabled = true;
            winnerNameDiv.classList.add('d-none');
            winnerNameDiv.textContent = '';

            // Stop any ongoing audio
            drumRoll.pause();
            drumRoll.currentTime = 0;
            winnerSound.pause();
            winnerSound.currentTime = 0;

            // Play drum roll when spinning starts
            drumRoll.play();

            // Fetch the winner from backend
            let winner;
            try {
                const response = await fetch('/raffle/pick-random-winner');
                if (!response.ok) {
                    const errorData = await response.json();
                    const errorMsg = errorData.error || 'No winner found';
                    throw new Error(errorMsg);
                }
                winner = await response.json();
            } catch (err) {
                winnerNameDiv.textContent = `Failed to pick a winner: ${err.message}`;
                winnerNameDiv.classList.remove('d-none');
                spinBtn.disabled = false;
                drumRoll.pause();
                return;
            }

            const winnerIdStr = winner.id.toString().padStart(5, '0');
            const digits = Array(5).fill(0);
            const spinDuration = 3000;
            const spinInterval = 50;

            const start = performance.now();

            function spinLoop(time) {
                let elapsed = time - start;

                for (let i = 0; i < 5; i++) {
                    const digitEl = document.getElementById('digit-' + i);

                    if (elapsed < spinDuration) {
                        if (elapsed > spinInterval * i) {
                            digits[i] = Math.floor(Math.random() * 10);
                            digitEl.textContent = digits[i];
                        }
                    } else {
                        digitEl.textContent = winnerIdStr[i];
                    }
                }

                if (elapsed < spinDuration + 5 * spinInterval) {
                    requestAnimationFrame(spinLoop);
                } else {
                    // Stop drum roll
                    drumRoll.pause();
                    drumRoll.currentTime = 0;

                    // Play winner sound
                    winnerSound.play();

                    winnerNameDiv.innerHTML = `🎉 <strong>Winner:</strong> ${winner.name} <br><small>(ID: ${winner.id})</small> 🎉`;
                    winnerNameDiv.classList.remove('d-none');
                    spinBtn.disabled = false;
                }
            }

            requestAnimationFrame(spinLoop);
        });
    </script>

@endsection

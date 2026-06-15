@extends('layouts.app')

@section('content')
<div class="dashboard-header" style="margin-bottom: 2rem;">
    <h2>Kalkulator Pintar</h2>
    <p>Hitung pengeluaran dan pemasukan Anda dengan cepat di sini.</p>
</div>

<div style="display: flex; justify-content: flex-start; width: 100%;">
    <div class="calculator-container" style="
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 24px;
        width: 100%;
        max-width: 400px;
        padding: 1.5rem;
        box-shadow: var(--shadow-lg);
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    ">
        
        <!-- Display Screen -->
        <div class="calc-screen" style="
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 1.5rem;
            text-align: right;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        ">
            <div id="calc-history" style="color: var(--text-muted); font-size: 0.9rem; min-height: 1.2rem; font-family: monospace;"></div>
            <div id="calc-display" style="color: white; font-size: 2.5rem; font-weight: bold; overflow-x: auto; white-space: nowrap; font-family: monospace; letter-spacing: -1px;">0</div>
        </div>

        <!-- Buttons Grid -->
        <div class="calc-keys" style="
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        ">
            <button class="calc-btn btn-action" onclick="inputAction('clear')" style="grid-column: span 2; background: rgba(244, 63, 94, 0.1); color: #f43f5e;">AC</button>
            <button class="calc-btn btn-action" onclick="inputAction('backspace')" style="background: rgba(255, 255, 255, 0.05); color: var(--text-main);">⌫</button>
            <button class="calc-btn btn-op" onclick="inputOp('/')" style="background: rgba(96, 165, 250, 0.1); color: #60a5fa;">÷</button>

            <button class="calc-btn btn-num" onclick="inputNum('7')">7</button>
            <button class="calc-btn btn-num" onclick="inputNum('8')">8</button>
            <button class="calc-btn btn-num" onclick="inputNum('9')">9</button>
            <button class="calc-btn btn-op" onclick="inputOp('*')" style="background: rgba(96, 165, 250, 0.1); color: #60a5fa;">×</button>

            <button class="calc-btn btn-num" onclick="inputNum('4')">4</button>
            <button class="calc-btn btn-num" onclick="inputNum('5')">5</button>
            <button class="calc-btn btn-num" onclick="inputNum('6')">6</button>
            <button class="calc-btn btn-op" onclick="inputOp('-')" style="background: rgba(96, 165, 250, 0.1); color: #60a5fa;">-</button>

            <button class="calc-btn btn-num" onclick="inputNum('1')">1</button>
            <button class="calc-btn btn-num" onclick="inputNum('2')">2</button>
            <button class="calc-btn btn-num" onclick="inputNum('3')">3</button>
            <button class="calc-btn btn-op" onclick="inputOp('+')" style="background: rgba(96, 165, 250, 0.1); color: #60a5fa;">+</button>

            <button class="calc-btn btn-num" onclick="inputNum('000')" style="font-size: 1.1rem;">000</button>
            <button class="calc-btn btn-num" onclick="inputNum('0')">0</button>
            <button class="calc-btn btn-num" onclick="inputNum('.')">.</button>
            <button class="calc-btn btn-equal" onclick="calculate()" style="background: var(--color-primary); color: white; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);">=</button>
        </div>

    </div>
</div>

<style>
    .calc-btn {
        border: none;
        border-radius: 16px;
        padding: 1.25rem 0;
        font-size: 1.5rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        font-family: 'Inter', sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-num {
        background: rgba(255, 255, 255, 0.03);
        color: var(--text-main);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    .calc-btn:hover {
        transform: translateY(-2px);
        filter: brightness(1.2);
    }
    
    .calc-btn:active {
        transform: translateY(1px) scale(0.95);
    }
    
    /* Scrollbar for display */
    #calc-display::-webkit-scrollbar {
        height: 4px;
    }
    #calc-display::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.2);
        border-radius: 4px;
    }
</style>

<script>
    let currentInput = '0';
    let previousInput = '';
    let operation = null;
    let shouldResetScreen = false;

    const display = document.getElementById('calc-display');
    const history = document.getElementById('calc-history');

    function updateDisplay() {
        // Format current input with thousand separators if it's a valid number without trailing dot
        let formatted = currentInput;
        if (!currentInput.includes('.') || currentInput.endsWith('.')) {
            // Keep it as is if it's just building decimals
            let parts = currentInput.split('.');
            if (parts[0] !== '') {
                 // Convert integer part to number then format, but keep minus sign logic intact
                 let intVal = parseInt(parts[0].replace(/-/g, ''));
                 if(!isNaN(intVal)){
                     let sign = currentInput.startsWith('-') ? '-' : '';
                     parts[0] = sign + new Intl.NumberFormat('id-ID').format(intVal);
                     formatted = parts.join('.');
                 }
            }
        }
        
        display.innerText = formatted;
        
        if (operation != null) {
            let opSymbol = operation;
            if (opSymbol === '*') opSymbol = '×';
            if (opSymbol === '/') opSymbol = '÷';
            
            let prevFormatted = previousInput;
            let prevIntVal = parseFloat(previousInput);
            if(!isNaN(prevIntVal)) {
                prevFormatted = new Intl.NumberFormat('id-ID').format(prevIntVal);
            }
            history.innerText = `${prevFormatted} ${opSymbol}`;
        } else {
            history.innerText = '';
        }
    }

    function inputNum(num) {
        if (currentInput === '0' && num !== '.') {
            currentInput = num;
        } else if (shouldResetScreen) {
            currentInput = num;
            shouldResetScreen = false;
        } else {
            if (num === '.' && currentInput.includes('.')) return;
            if (num === '000' && currentInput === '0') return;
            currentInput += num;
        }
        updateDisplay();
    }

    function inputOp(op) {
        if (operation !== null && !shouldResetScreen) {
            calculate();
        }
        previousInput = currentInput;
        operation = op;
        shouldResetScreen = true;
        updateDisplay();
    }

    function calculate() {
        let result;
        const prev = parseFloat(previousInput);
        const current = parseFloat(currentInput);

        if (isNaN(prev) || isNaN(current)) return;

        switch (operation) {
            case '+':
                result = prev + current;
                break;
            case '-':
                result = prev - current;
                break;
            case '*':
                result = prev * current;
                break;
            case '/':
                if (current === 0) {
                    alert("Tidak dapat membagi dengan nol!");
                    inputAction('clear');
                    return;
                }
                result = prev / current;
                break;
            default:
                return;
        }

        currentInput = parseFloat(result.toFixed(2)).toString();
        operation = null;
        previousInput = '';
        shouldResetScreen = true;
        updateDisplay();
    }

    function inputAction(action) {
        if (action === 'clear') {
            currentInput = '0';
            previousInput = '';
            operation = null;
        } else if (action === 'backspace') {
            if (shouldResetScreen) return;
            currentInput = currentInput.slice(0, -1);
            if (currentInput === '' || currentInput === '-') {
                currentInput = '0';
            }
        }
        updateDisplay();
    }
</script>
@endsection
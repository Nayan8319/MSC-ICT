// filename: programs.js
const readline = require("readline");

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout,
});

// -------------------------------
// 1. PRIME NUMBERS till N + SUM
// -------------------------------
function isPrime(num) {
  if (num < 2) return false;
  for (let i = 2; i <= Math.sqrt(num); i++) {
    if (num % i === 0) return false;
  }
  return true;
}

function primesTillN(n) {
  let primes = [];
  let sum = 0;

  for (let i = 1; i <= n; i++) {
    if (isPrime(i)) {
      primes.push(i);
      sum += i;
    }
  }

  console.log(`Prime numbers from 1 to ${n}:`, primes);
  console.log("Sum of primes:", sum);
}

// -------------------------------
// 2. FIBONACCI SERIES
// -------------------------------
function fibonacci(n) {
  let series = [0, 1];

  for (let i = 2; i < n; i++) {
    series[i] = series[i - 1] + series[i - 2];
  }

  console.log("Fibonacci series:", series.slice(0, n).join(" "));
}

// -------------------------------
// 3. PALINDROME WORDS in a SENTENCE
// -------------------------------
function cleanString(str) {
  return str
    .toLowerCase()
    .replace(/[^a-z0-9]/g, ""); // keep only alphanumeric
}

function isPalindromeWord(word) {
  let clean = cleanString(word);
  let left = 0,
    right = clean.length - 1;

  while (left < right) {
    if (clean[left] !== clean[right]) return false;
    left++;
    right--;
  }
  return true;
}

function palindromeSentence(sentence) {
  let words = sentence.split(/\s+/);
  let palindromes = words.filter((w) => isPalindromeWord(w));
  console.log("Palindrome words:", palindromes);
}

// -------------------------------
// 4. PALINDROME CHECK for WHOLE SENTENCE
// -------------------------------
function isPalindromeSentence(sentence) {
  let clean = cleanString(sentence);
  let left = 0,
    right = clean.length - 1;

  while (left < right) {
    if (clean[left] !== clean[right]) return false;
    left++;
    right--;
  }
  return true;
}

// -------------------------------
// MAIN FLOW (Step-by-step input)
// -------------------------------
rl.question("Enter a number to find primes till that number: ", (n1) => {
  primesTillN(parseInt(n1));

  rl.question("Enter how many Fibonacci numbers you want: ", (n2) => {
    fibonacci(parseInt(n2));

    rl.question("Enter a word or sentence: ", (sentence) => {
      console.log("Is single input palindrome? ", isPalindromeWord(sentence));
      palindromeSentence(sentence);
      console.log("Is whole sentence palindrome? ", isPalindromeSentence(sentence));

      rl.close();
    });
  });
});










<?php include "templates/head.php"; ?>

<body>
  <div class="header">
    <?php include "templates/header.php"; ?>
  </div>

  <div class="page-payment-wrapper">
    <div class="container">
      <div class="header-block-wrapper">
        <div class="left-block">
          <h3 class="title">Send USDC on Ethereum network</h3>
          <p class="description">Open your crypto wallet and scan the QR code, or copy the USDC address below to make a
            payment</p>
        </div>
        <div class="right-block">
          <div id="progress"></div>
        </div>
      </div>

      <div class="description-detail-block">
        <span class="icon">

<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M1.66602 9.99935C1.66602 5.40018 5.39935 1.66602 9.99935 1.66602C14.6077 1.66602 18.3327 5.40018 18.3327 9.99935C18.3327 14.6002 14.6077 18.3327 9.99935 18.3327C5.39935 18.3327 1.66602 14.6002 1.66602 9.99935ZM9.26562 6.84103C9.26562 6.44186 9.59896 6.1077 9.99896 6.1077C10.399 6.1077 10.724 6.44186 10.724 6.84103V10.5244C10.724 10.9252 10.399 11.2494 9.99896 11.2494C9.59896 11.2494 9.26562 10.9252 9.26562 10.5244V6.84103ZM10.0068 13.9002C9.59844 13.9002 9.27344 13.5668 9.27344 13.1668C9.27344 12.7668 9.59844 12.4418 9.99844 12.4418C10.4068 12.4418 10.7318 12.7668 10.7318 13.1668C10.7318 13.5668 10.4068 13.9002 10.0068 13.9002Z" fill="#F9BC1E"/>
</svg>

        </span>
        <p class="description">Only send USDC to this address from Ethereum network. Don’t send USDC from other networks or it will result in a loss of funds.</p>
      </div>

      <div class="block-payment-wrapper">
        <img src="./images/qa-code-image.png" alt="" class="qa-code-image">
        <div class="list-item">
          <div class="item">
            <div class="left-content">
              <span class="label">USDC Address</span>
              <span class="value">0x48374abc438053408kdjkldfjglkdfjgl584545</span>
            </div>
            <button class="btn-copy">Copy</button>
          </div>
          <div class="item">
            <div class="left-content">
              <span class="label">Total Amount</span>
              <span class="value">50.0 USDC</span>
            </div>
            <button class="btn-copy">Copy</button>
          </div>
        </div>
      </div>

      <div class="complete-your-checkout-wrapper">
        <h4 class="title">Have you completed your checkout</h4>
        <p class="description">
          Please upload your proof of payment (you can upload your receipt screenshot or paste your receipt link here)
        </p>

        <input type="text" name="" value="" placeholder="Enter receipt link" class="input-text">

        <div class="input-file-wrapper">
          <label for="file-upload" class="custom-file-upload">
            Choose file
          </label>
          <input id="file-upload" type="file" />
        </div>

        <div class="submit-wrapper">
          <button class="btn-submit">Submit</button>
        </div>
      </div>
    </div>
  </div>
  <?php include "templates/footer.php"; ?>

  <script>
  const FULL_DASH_ARRAY = 283;
  const WARNING_THRESHOLD = 10;
  const ALERT_THRESHOLD = 5;

  const COLOR_CODES = {
    info: {
      color: "green"
    },
    warning: {
      color: "orange",
      threshold: WARNING_THRESHOLD
    },
    alert: {
      color: "red",
      threshold: ALERT_THRESHOLD
    }
  };

  const TIME_LIMIT = 200
  let timePassed = 0;
  let timeLeft = TIME_LIMIT;
  let timerInterval = null;
  let remainingPathColor = COLOR_CODES.info.color;

  document.getElementById("progress").innerHTML = `
<div class="base-timer">
  <svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
    <g class="base-timer__circle">
      <circle class="base-timer__path-elapsed" cx="50" cy="50" r="45"></circle>
      <path
        id="base-timer-path-remaining"
        stroke-dasharray="283"
        class="base-timer__path-remaining ${remainingPathColor}"
        d="
          M 50, 50
          m -45, 0
          a 45,45 0 1,0 90,0
          a 45,45 0 1,0 -90,0
        "
      ></path>
    </g>
  </svg>
  <span id="base-timer-label" class="base-timer__label">${formatTime(
    timeLeft
  )}</span>
</div>
`;

  startTimer();

  function onTimesUp() {
    clearInterval(timerInterval);
  }

  function startTimer() {
    timerInterval = setInterval(() => {
      timePassed = timePassed += 1;
      timeLeft = TIME_LIMIT - timePassed;
      document.getElementById("base-timer-label").innerHTML = formatTime(
        timeLeft
      );
      setCircleDasharray();
      setRemainingPathColor(timeLeft);

      if (timeLeft === 0) {
        onTimesUp();
      }
    }, 1000);
  }

  function formatTime(time) {
    const minutes = Math.floor(time / 60);
    let seconds = time % 60;

    if (seconds < 10) {
      seconds = `0${seconds}`;
    }

    return `${minutes}:${seconds}`;
  }

  function setRemainingPathColor(timeLeft) {
    const {
      alert,
      warning,
      info
    } = COLOR_CODES;
    if (timeLeft <= alert.threshold) {
      document
        .getElementById("base-timer-path-remaining")
        .classList.remove(warning.color);
      document
        .getElementById("base-timer-path-remaining")
        .classList.add(alert.color);
    } else if (timeLeft <= warning.threshold) {
      document
        .getElementById("base-timer-path-remaining")
        .classList.remove(info.color);
      document
        .getElementById("base-timer-path-remaining")
        .classList.add(warning.color);
    }
  }

  function calculateTimeFraction() {
    const rawTimeFraction = timeLeft / TIME_LIMIT;
    return rawTimeFraction - (1 / TIME_LIMIT) * (1 - rawTimeFraction);
  }

  function setCircleDasharray() {
    const circleDasharray = `${(
    calculateTimeFraction() * FULL_DASH_ARRAY
  ).toFixed(0)} 283`;
    document
      .getElementById("base-timer-path-remaining")
      .setAttribute("stroke-dasharray", circleDasharray);
  }
  </script>
</body>

</html>
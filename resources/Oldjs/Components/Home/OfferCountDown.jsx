import { useState, useEffect } from 'react';

const OfferCountDown = ({date}) => {
  const [timeLeft, setTimeLeft] = useState({
    days: 0,
    hours: 0,
    minutes: 0,
    seconds: 0,
  });
  const [isTargetDate, setIsTargetDate] = useState(false);

  useEffect(() => {
    const second = 1000;
    const minute = second * 60;
    const hour = minute * 60;
    const dayInMs = hour * 24;

    // Convert the date string to a Date object
    const targetDate = new Date(date).getTime();
    const interval = setInterval(() => {
      const now = new Date().getTime();
      const distance = targetDate - now;

      if (distance < 0) {
        setIsTargetDate(true);
        clearInterval(interval);
      } else {
        setTimeLeft({
          days: Math.floor(distance / dayInMs),
          hours: Math.floor((distance % dayInMs) / hour),
          minutes: Math.floor((distance % hour) / minute),
          seconds: Math.floor((distance % minute) / second),
        });
      }
    }, 1000);

    return () => clearInterval(interval);
  }, [date]); // Depend on `date` prop

  if (isTargetDate) {
    return (
      <div className="container">
        <h1 id="headline"></h1>
        <div id="content" className="emoji">
          <span>🥳</span>
          <span>🎉</span>
          <span>🎂</span>
        </div>
      </div>
    );
  }

  if (isTargetDate) {
    return (
      <div className="container">
        <h1 id="headline">Offer Closed!</h1>
      </div>
    );
  }

  return (
    <div className="TimerContainer">
      <div id="countdown">
        <div className="days"> <span id="days">{timeLeft.days}</span> days</div>
        <ul>
          {/* <li>
            <span id="days">{timeLeft.days}</span> days
          </li> */}
          <li>
            <span id="hours">{timeLeft.hours}</span> Hours
          </li>
          <li>
            <span id="minutes">{timeLeft.minutes}</span> Minutes
          </li>
          <li>
            <span id="seconds">{timeLeft.seconds}</span> Seconds
          </li>
        </ul>
      </div>
    </div>
  );
};

export default OfferCountDown;

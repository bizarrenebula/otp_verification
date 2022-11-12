import axios from "axios";
import { useState } from "react";

export default function Otp({ user }) {
  const url = "http://localhost:3030/verify.php";

  const [otp, setOtp] = useState(null);
  const [msg, setMsg] = useState(null);

  const handleChange = (e) => {
    setOtp(e.target.value);
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    axios
      .post(url, {
        otp: otp,
        user: user,
      })
      .then((res) => {
        if (res.data.ecode === 1) {
          setMsg("OTP Verified!");
          setTimeout(() => {
            setMsg(null);
          }, 5000);
          console.log("MESSAGE FROM SERVER:");
          console.log(res.data.message);
        }
        if (res.data.ecode === 0) {
          setMsg("Verification failed!");
          setTimeout(() => {
            setMsg(null);
          }, 5000);
        }
      });
  };

  const generateOTP = (e) => {
    e.preventDefault();

    axios
      .post("http://localhost:3030/otp_update.php", {
        otp: otp,
        user: user,
      })
      .then((res) => {
        if (res.data.message) {
          setMsg(res.data.message);
          setTimeout(() => {
            setMsg(null);
          }, 5000);
        }
        if (res.data.otp) {
          setMsg("New OTP Generated!");
          setTimeout(() => {
            setMsg(null);
          }, 5000);
          console.log("SIMULATING MOBILE NETWORK PROVIDER");
          console.log(
            "Generated OTP: " + res.data.otp + " for " + res.data.email
          );
        }
      });
  };

  return (
    <div>
      <form method="post" onSubmit={handleSubmit}>
        <table align="center">
          <tbody>
            <tr>
              <td>
                <label htmlFor="otp">Enter OTP</label>
              </td>
            </tr>
            <tr>
              <td>
                <input type="text" name="otp" onChange={handleChange} />
              </td>
            </tr>
            <tr>
              <td>
                <input type="submit" value="Verify OTP" id="verify" />
              </td>
            </tr>
          </tbody>
        </table>
      </form>
      <form method="post" onSubmit={generateOTP}>
        <table>
          <tbody>
            <tr>
              <td>
                <input type="submit" value="Get new OTP" id="getnew" />
              </td>
            </tr>
            <tr>
              <td>{msg}</td>
            </tr>
          </tbody>
        </table>
      </form>
    </div>
  );
}

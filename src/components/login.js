import axios from "axios";
import { useState } from "react";
import "react-phone-number-input/style.css";

import PhoneInput from "react-phone-number-input";

export default function Login({ setUser, setToggle }) {
  const url = "http://localhost:3030/signup.php";

  const [userData, setUserData] = useState({
    email: null,
    pass: null,
  });

  const [phone, setPhone] = useState(null);

  const [err, setErr] = useState(null);
  const [msg, setMsg] = useState(null);

  const updateEmail = (e) => {
    const email = e.target.value;
    setUser(email);
    setUserData({ ...userData, email: email });
  };

  const updatePass = (e) => {
    const pass = e.target.value;
    setUserData({ ...userData, pass: pass });
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    if (userData.email && phone && userData.pass) {
      axios
        .post(url, {
          userData,
          phone,
        })
        .then((res) => {
          if (res.data.message) {
            setErr("Registration failed! Try again...");
            setTimeout(() => {
              setErr(null);
            }, 2000);
          }
          if (res.data.otp) {
            setMsg("Registration successfull!");
            setTimeout(() => {
              setMsg(null);
            }, 2000);
            console.log("SIMULATING MOBILE NETWORK PROVIDER");
            console.log(
              "Generated OTP: " +
                res.data.otp +
                " for " +
                res.data.email +
                " with tel.no: " +
                res.data.phone
            );
            setToggle("visible");
          }
        })
        .catch(function (error) {
          if (error.response) {
            // Request made and server responded
            console.log(error.response.message);
          } else if (error.request) {
            // The request was made but no response was received
            console.log(error.request);
          } else {
            // Something happened in setting up the request that triggered an Error
            console.log("Error", error.message);
          }
        });
    } else {
      setErr("Please, fill all the form fields...");
      setTimeout(() => {
        setErr(null);
      }, 2000);
    }
  };

  return (
    <form method="post" onSubmit={handleSubmit}>
      <table align="center">
        <tbody>
          <tr>
            <td>
              <label htmlFor="email">E-Mail</label>
            </td>
          </tr>
          <tr>
            <td>
              <input type="email" name="email" onChange={updateEmail} />
            </td>
          </tr>
          <tr>
            <td>
              <label htmlFor="tel">Phone Number</label>
            </td>
          </tr>
          <tr>
            <td>
              <PhoneInput
                placeholder="Enter phone number"
                value={phone}
                onChange={setPhone}
              />
            </td>
          </tr>
          <tr>
            <td>
              <label htmlFor="pass">Password</label>
            </td>
          </tr>
          <tr>
            <td>
              <input type="password" name="pass" onChange={updatePass} />
            </td>
          </tr>
          <tr>
            <td>
              <input type="submit" value="Get OTP" />
            </td>
          </tr>
          <tr>
            {err ? (
              <td style={{ color: "red" }}>{err}</td>
            ) : (
              <td style={{ color: "green" }}>{msg}</td>
            )}
          </tr>
        </tbody>
      </table>
    </form>
  );
}

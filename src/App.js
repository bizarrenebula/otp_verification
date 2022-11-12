import Login from "./components/login";
import Otp from "./components/otp";
import "./styles.css";

import { useState } from "react";

export default function App() {
  const [user, setUser] = useState(null);
  const [toggle, setToggle] = useState("hidden");

  return (
    <div className="container">
      <div className="item">
        <Login setUser={setUser} setToggle={setToggle} />
      </div>
      <div className="item" style={{ visibility: toggle }}>
        <Otp user={user} />
      </div>
    </div>
  );
}

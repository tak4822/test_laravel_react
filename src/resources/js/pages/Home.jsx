import React, { useEffect, useState } from 'react';
import Wrapper from '../components/Wrapper';
import axios from 'axios';

const Home = () => {
  const [user, setUser] = useState({
    first_name: "",
    last_name: "",
    email: "",
  });

  useEffect(() => {
    (
        async () => {
        const { data } = await axios.get('/api/user', {withCredentials: true});
        setUser(data);
        console.log("User", data);
      }
    )();
  }, []);

  
  return (
    <Wrapper>
      <h1>ホーム</h1>
      <h2>{ user?.first_name } { user?.last_name }</h2>
      <h2>{ user?.email }</h2>
    </Wrapper>
  );
};

export default Home;
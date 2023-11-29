import { ref, computed } from 'vue';
import { defineStore } from 'pinia';
// import axios from 'axios';

export const useAuthStore = defineStore('auth', () => {
  const user = ref(localStorage.getItem('USER') || null);
  const userSiswa = ref(localStorage.getItem('USERSISWA') || null);
  const token = ref(localStorage.getItem('TOKEN') || null);
  const tokenSiswa = ref(localStorage.getItem('TOKENSISWA') || null);

  // const isAuthenticated = computed(() => !!(user.value));
  // const isAuthenticatedSiswa = computed(() => !!(userSiswa.value));
  const isAuthenticated = computed(() => !!(user.value && token.value));
  const isAuthenticatedSiswa = computed(() => !!(userSiswa.value && tokenSiswa.value));

  const setUser = (data, role) => {
    if(role == 'admin') {
      user.value = data;
      !user.value
        ? localStorage.removeItem('USER')
        : localStorage.setItem('USER', JSON.stringify(data));
    }else{
      userSiswa.value = data;
      !userSiswa.value
        ? localStorage.removeItem('USERSISWA')
        : localStorage.setItem('USERSISWA', JSON.stringify(data));
    }
  };

  const setToken = (data, role) => {
    if(role == 'admin') {
      token.value = data;
      !token.value ? localStorage.removeItem('TOKEN') : localStorage.setItem('TOKEN', data);
    }else{
      tokenSiswa.value = data;
      !tokenSiswa.value ? localStorage.removeItem('TOKENSISWA') : localStorage.setItem('TOKENSISWA', data);
    }
  };

  const getUser = async () => {
    const token = localStorage.getItem('TOKEN');
    if (!token) return;

    try {
        const { data } = await instanceAdmin({
          url: '/admin/auth/profil',
          method: 'GET',
          headers : {
            'Authorization' : `Bearer ${token}`
          }
        })
        setUser(data.data, 'admin');
    } catch (error) {
        setToken(null, 'admin');
        setUser(null, 'admin');
    }
  };

  const getUserSiswa = async () => {
    const token = localStorage.getItem('TOKENSISWA');
    if (!token) return;

    try {
        const { data } = await instanceSiswa({
          url: '/peserta/account/profil',
          method: 'GET',
          headers : {
            'Authorization' : `Bearer ${token}`
          }
        })

        setUser(data.data, 'siswa');
    } catch (error) {
        setToken(null, 'siswa');
        setUser(null, 'siswa');
    }
  };

  const login = async (payload) => {
    try {
        // const { data } = await axios.post('/admin/auth/issue-token', payload);
        const { data } = await instanceAdmin({
          url: '/admin/auth/issue-token',
          method: 'POST',
          data: payload,
        })
        await Promise.all([setToken(data.token.access_token, 'admin'), getUser()]);
        // axios.defaults.headers.common['Authorization'] = `Bearer ${data.token.access_token}`
    } catch (error) {
        setToken(null, 'admin');
        setUser(null, 'admin');

    if (error.response) {
        throw error.response;
    }
    throw error;
    }
  };

  const loginSiswa = async (payload) => {
    try {
        // const { data } = await axios.post('/peserta/account/issue-token', payload);
        const { data } = await instanceSiswa({
          url: '/peserta/account/issue-token',
          method: 'POST',
          data: payload,
        })
        await Promise.all([setToken(data.token.access_token, 'siswa'), getUserSiswa()]);
        // axios.defaults.headers.common['Authorization'] = `Bearer ${data.token.access_token}`
    } catch (error) {
        setToken(null, 'siswa');
        setUser(null, 'siswa');

    if (error.response) {
        throw error.response;
    }
    throw error;
    }
  };

  const logoutSiswa = () => {
    return instanceSiswa({
      url: "/peserta/account/logout",
      method: 'POST',
      headers: {
        Accept: 'application/json',
        Authorization: `Bearer ${tokenSiswa.value}`
      }
    }).then(() => {
      setToken(null, 'siswa');
      setUser(null, 'siswa');
      location.reload()
    });
  };

  const logout = () => {
    // return axios.post("/admin/auth/logout", {
    //   headers: {
    //     Accept: 'application/json',
    //     Authorization: `Bearer ${token.value}`
    //   }
    // })
    
    return instanceAdmin({
      url: "/admin/auth/logout",
      method: 'POST',
      headers: {
        Accept: 'application/json',
        Authorization: `Bearer ${token.value}`
      }
    }).then(() => {
      setToken(null, 'admin');
      setUser(null, 'admin');
      location.reload()
    });
  };

  return { user, userSiswa, token, tokenSiswa, isAuthenticated, isAuthenticatedSiswa, getUser, getUserSiswa, login, loginSiswa, logout, logoutSiswa };
});
import { ref, computed } from 'vue';
import { defineStore } from 'pinia';
// import axios from 'axios';

export const useTesStore = defineStore('tes', () => {
    const isRunningTest = ref(localStorage.getItem('isRunningTest') || 0);
    const ujianSiswa = ref(localStorage.getItem('ujianSiswa') || null);

    const setRunningTest = (data) => {
        isRunningTest.value = data;
        !isRunningTest.value ? localStorage.removeItem('isRunningTest') : localStorage.setItem('isRunningTest', data);
    }

    const setDataTest = (data) => {
        ujianSiswa.value = data;
        !ujianSiswa.value ? localStorage.removeItem('ujianSiswa') : localStorage.setItem('ujianSiswa', JSON.stringify(data));
    }

    const runTest = async (id) => {
        try {
            const { data } = await instanceSiswa({
                url: `/peserta/tes/${id}/mulai`,
                method: 'POST',
            })
            await Promise.all([setRunningTest(1), setDataTest(data.data)]);
        } catch (error) {
            setRunningTest(0);
            setDataTest(null);
    
            if (error.response) {
                throw error.response;
            }
            throw error;
        }
    }

    const stopTest = async (id, jumlah) => {
        try {
            const { data } = await instanceSiswa({
                url: `/peserta/tes/${id}/selesai`,
                method: 'POST',
                data: { jumlah_soal: jumlah }
            })
            await Promise.all([setRunningTest(null), setDataTest(null)]);
        } catch (error) {
            // setRunningTest(0);
            // setDataTest(null)
    
            if (error.response) {
                throw error.response;
            }
            throw error;
        }
    }

    return { isRunningTest, runTest, stopTest, setRunningTest, setDataTest };
});
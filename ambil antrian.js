document.addEventListener('DOMContentLoaded', function() {
  const poliSelect = document.getElementById('poli');
  const dokterSelect = document.getElementById('dokter');
  const counterDisplay = document.getElementById('currentNumber');
  const takeNumberBtn = document.getElementById('takeNumberBtn');
  const queueList = document.getElementById('queueList');
  const resetBtn = document.getElementById('resetBtn');

  const doctorsByPoli = {
    poli_anak: ['Dr. Jasmine Cooper - Spesialis Anak'],
    poli_bedah: ['Dr. David Brown - Spesialis Bedah Ortopedi'],
    poli_kulit_dan_kelamin: ['Dr. Linda Davis - Spesialis Dermatologi'],
    poli_tht: ['Dr. Sarah Williams - Spesialis THT'],
    poli_penyakit_dalam: ['Dr. Michael Lee - Spesialis Penyakit Dalam'],
    poli_ginekologi: ['Dr. Jennifer Clark - Spesialis Ginekologi']
  };

  let currentNumber = {}; // Menyimpan nomor antrian per poli

  loadQueueData(); // Muat data antrian dari server

  // Inisialisasi display
  function loadQueueData() {
    updateQueueList();
    updateCounterDisplay(poliSelect.value);  // Memastikan counter sesuai dengan poli yang dipilih
  }

  // Fungsi untuk memperbarui daftar dokter sesuai dengan poli yang dipilih
  poliSelect.addEventListener('change', function() {
    const selectedPoli = poliSelect.value;
    updateDoctorList(selectedPoli);
    updateCounterDisplay(selectedPoli);
  });

  // Fungsi untuk memperbarui display jumlah antrian
  dokterSelect.addEventListener('change', function() {
    const selectedPoli = poliSelect.value;
    updateCounterDisplay(selectedPoli);
  });

  // Fungsi untuk mengambil nomor antrian
  takeNumberBtn.addEventListener('click', function() {
    const selectedPoli = poliSelect.value;
    const selectedDokter = dokterSelect.value;

    if (selectedPoli && selectedDokter) {
      // Kirim request untuk mengambil nomor antrian ke server
      fetch('ambil_antrian.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `poli=${selectedPoli}&dokter=${selectedDokter}`
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          currentNumber[selectedPoli] = data.nomor_antrian;
          updateCounterDisplay(selectedPoli);
          updateQueueList();
        } else {
          alert('Terjadi kesalahan: ' + data.message);
        }
      })
      .catch(error => alert('Terjadi kesalahan saat mengambil nomor antrian: ' + error));
    } else {
      alert('Pilih poli dan dokter terlebih dahulu.');
    }
  });

  // Reset antrian
  resetBtn.addEventListener('click', function() {
    // Reset antrian di server
    fetch('reset_antrian.php')
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          currentNumber = {};  // Reset nomor antrian
          counterDisplay.textContent = 0;
          updateQueueList();
        } else {
          alert('Gagal mereset antrian.');
        }
      })
      .catch(error => alert('Terjadi kesalahan saat mereset antrian: ' + error));
  });

  // Fungsi untuk memperbarui daftar dokter berdasarkan poli yang dipilih
  function updateDoctorList(selectedPoli) {
    dokterSelect.innerHTML = '<option value="">Pilih Dokter</option>';
    if (selectedPoli && doctorsByPoli[selectedPoli]) {
      doctorsByPoli[selectedPoli].forEach(doctor => {
        const option = document.createElement('option');
        option.value = doctor;
        option.textContent = doctor;
        dokterSelect.appendChild(option);
      });
    }
  }

  // Fungsi untuk memperbarui display jumlah antrian berdasarkan poli yang dipilih
  function updateCounterDisplay(selectedPoli) {
    if (selectedPoli) {
      counterDisplay.textContent = currentNumber[selectedPoli] || 0;
    } else {
      counterDisplay.textContent = 0;
    }
  }

  // Fungsi untuk memperbarui daftar antrian
  function updateQueueList() {
    queueList.innerHTML = '';
    fetch('ambil_antrian.php')
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          data.antrian.forEach(queue => {
            const listItem = document.createElement('li');
            listItem.textContent = `Poli ${queue.poli} - Dokter: ${queue.dokter} - No. Antrian: ${queue.nomor_antrian} - Waktu: ${queue.waktu_antrian}`;
            queueList.appendChild(listItem);
          });
        } else {
          alert('Terjadi kesalahan saat memuat daftar antrian: ' + data.message);
        }
      })
      .catch(error => alert('Terjadi kesalahan saat memuat daftar antrian: ' + error));
  }
});

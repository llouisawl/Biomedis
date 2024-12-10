document.addEventListener("DOMContentLoaded", function () {
  const serviceDropdown = document.getElementById("service");
  const doctorDropdown = document.getElementById("doctor");
  const form = document.getElementById("appointmentForm");
  const successMessage = document.getElementById("successMessage");

  // Daftar dokter berdasarkan layanan
  const doctorsByService = {
    poli_anak: ["Dr. Jasmine Cooper - Spesialis Anak"],
    poli_bedah: ["Dr. David Brown - Spesialis Bedah Ortopedi"],
    poli_kulit_dan_kelamin: ["Dr. Linda Davis - Spesialis Dermatologi"],
    poli_tht: ["Dr. Sarah Williams - Spesialis THT"],
    poli_penyakit_dalam: ["Dr. Michael Lee - Spesialis Penyakit Dalam"],
    poli_ginekologi: ["Dr. Jennifer Clark - Spesialis Ginekologi"],
  };

  // Event listener untuk perubahan pilihan layanan
  serviceDropdown.addEventListener("change", function () {
    const selectedService = serviceDropdown.value;
    doctorDropdown.innerHTML = '<option value="">Pilih dokter</option>';

    if (selectedService && doctorsByService[selectedService]) {
      doctorsByService[selectedService].forEach((doctor) => {
        const option = document.createElement("option");
        option.value = doctor;
        option.textContent = doctor;
        doctorDropdown.appendChild(option);
      });
    }
  });

  // Event listener untuk submit form
  form.addEventListener("submit", function (event) {
    event.preventDefault(); // Mencegah form mengirimkan data secara langsung

    const formData = new FormData(form);
    const userId = sessionStorage.getItem("user_id"); // Mengambil ID user dari session
    const userName = sessionStorage.getItem("user_name"); // Mengambil nama user dari session

    if (userId && userName) {
      formData.append("user_id", userId);
      formData.set("name", userName); // Menggunakan nama dari session untuk patient_name
    }

    // Kirim data form ke server menggunakan fetch
    fetch("submit_appointment.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.status === "success") {
          // Menampilkan pesan sukses
          successMessage.style.display = "block";
          successMessage.textContent = data.message;

          // Mereset form dan dropdown dokter
          form.reset();
          doctorDropdown.innerHTML =
            '<option value="">Pilih layanan terlebih dahulu</option>';
        } else {
          alert(data.message);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("Terjadi kesalahan saat memproses data. Silakan coba lagi.");
      });
  });
});

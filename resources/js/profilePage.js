import { globalScript } from "./globalScript";

export default function profilePage() {
    return {
        form: {
            name: "",
            position: "",
            image: null,
        },
        existingImageUrl: "{{ asset('assets/image/avatar-default.png') }}",
        global: new globalScript(),

        init() {
            this.loadProfile();
        },

        async loadProfile() {
            try {
                const response = await this.global.getProfile();
                const user = response.data.data.data;

                this.form = {
                    name: user.name,
                    position: user.position,
                    image: null,
                };

                this.existingImageUrl = user.image
                    ? `/storage/${user.image}`
                    : "{{ asset('assets/image/avatar.png') }}";
            } catch (error) {
                this.global.SwalErrorProses("Gagal memuat profil.");
            }
        },

        handleAvatarUpload(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.form.image = file;
                    this.existingImageUrl = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },

        async saveProfile() {
            try {
                const formData = new FormData();
                formData.append("name", this.form.name);
                formData.append("position", this.form.position);

                if (this.form.image) {
                    formData.append("image", this.form.image);
                }

                await this.global.updateProfile(formData);
                this.global.SwalSuccess("Profil berhasil disimpan.");
            } catch (error) {
                this.global.SwalError("Gagal menyimpan profil.");
            }
        },
    };
}

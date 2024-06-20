<template>
    <section>
        <video class="responsive-video" autoplay loop muted>
            <source src="../../../videos/vid-1.mp4" type="video/mp4" />
            Your browser does not support the video tag.
        </video>
        <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo
            laudantium dolore molestias repellat quas deleniti doloremque
            minima, itaque tenetur perspiciatis beatae doloribus neque
            repudiandae esse, ipsum sapiente sunt. Quibusdam, laudantium.
        </p>
    </section>
    <div class="video-container">
        <h1>Ini Halaman Home</h1>

        <p>Result API :</p>
    </div>
</template>

<style scoped>
.video-container {
    max-width: 800px;
    /* margin: 0 auto; */
    /* padding: 20px; */
}

.responsive-video {
    width: 100vw;
    height: 100vh;
    object-fit: cover;

}
</style>

<template>
    <div class="footer">
        <div class="wrap">
            <div class="lists">
                <div class="about grid">
                    <h4>About Us</h4>
                    <ul>
                        <li><a href="#">About US</a></li>
                        <li><a href="#">How it works</a></li>
                        <li><a href="#">Our Terms and Privacy</a></li>
                    </ul>
                </div>
                <div class="contact grid">
                    <h4>Contact Us</h4>
                    <ul>
                        <li><i class="fa fa-phone"></i>&nbsp; 08023572852</li>
                        <li><i class="fa fa-envelope"></i>&nbsp; info@lemlem.com</li>
                    </ul>
                
                </div>
                <div class="socials grid">
                    <h4>Our Socials</h4>
                    <ul>
                        <li>
                            <a href="/facebook.com"><i class="fa fa-facebook"></i></a>
                            <a href="/twitter.com"><i class="fa fa-twitter"></i></a>
                            <a href="/instagram.com"><i class="fa fa-instagram"></i></a>
                        </li>
                        <li><a href="#">Sign In</a></li>
                        <li><a href="#">Sign Up</a></li>
                    </ul>
                </div>
            </div>
            <div class="copy">
                &copy; - {{ year }} &nbsp; lemlem.com &nbsp;&nbsp; All rights reserved
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            year: new Date().getFullYear()
        }
    },
}
</script>

<style lang="scss" scoped>
    
</style>

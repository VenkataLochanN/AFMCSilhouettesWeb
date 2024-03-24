<?php
    
    
    function blockstarter_setup() {
        
        // Make theme available for translation.
        load_theme_textdomain( 'blockstarter', get_template_directory() . '/languages' );
        
        // Add theme support
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'wp-block-styles' );
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'editor-styles' );
        add_theme_support( 'html5', array( 'comment-form', 'comment-list' ) );
        add_theme_support( 'responsive-embeds' );
    }
    add_action( 'after_setup_theme', 'blockstarter_setup' );
    
    /**
        * Enqueue scripts and styles
    */
    function blockstarter_scripts() {
        $version = wp_get_theme( 'blockstarter' )->get( 'Version' );
        // Stylesheet
        wp_enqueue_style( 'blockstarter-styles', get_theme_file_uri( '/style.css' ), array(), $version );
        
        if ( is_rtl() ) {
            wp_enqueue_style( 'rtl-css', get_template_directory_uri() . '/assets/css/rtl.css', 'rtl_css' );
        }
    }
    add_action( 'wp_enqueue_scripts', 'blockstarter_scripts' );
    
    function blockstarter_excerpt_length( $length ) {
        return 25;
    }
    add_filter( 'excerpt_length', 'blockstarter_excerpt_length' );
    
    /** Add default theme logo if no logo is specified */
    function blockstarter_get_custom_logo_callback( $html ) {
        if ( has_custom_logo() ) {
            return $html;
            } else {
            $logo = '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 135.467 135.467" fill="none"><path d="M68.352 56.003L6.616 31.309 68.352 6.615l61.736 24.694-28.768 11.507z" stroke="#262626" stroke-linejoin="round" stroke-width="13.229"/><path d="M9.073 99.25c-3.392-1.356-7.241.294-8.598 3.686s.293 7.241 3.685 8.598zm59.28 30.836l-2.456 6.142c1.577.631 3.336.631 4.912 0zm64.192-18.553c3.392-1.357 5.042-5.207 3.686-8.598s-5.207-5.042-8.598-3.686zM9.073 62.209c-3.392-1.356-7.241.294-8.598 3.686s.293 7.241 3.685 8.598zm59.28 30.836l-2.456 6.142c1.577.631 3.336.631 4.912 0zm64.192-18.553c3.392-1.357 5.042-5.207 3.686-8.598s-5.207-5.042-8.598-3.686zM4.16 111.534l61.736 24.694 4.912-12.284L9.073 99.25zm66.649 24.694l61.736-24.694-4.912-12.284-61.736 24.694zM4.16 74.492l61.736 24.694 4.912-12.284L9.073 62.209zm66.649 24.694l61.736-24.694-4.912-12.284-61.736 24.694z" fill="#262626"/></svg>';
            return '<a href="' . esc_attr( home_url() ) . '">' . $logo . '</a>';
        }
    }
    
    add_filter( 'get_custom_logo', 'blockstarter_get_custom_logo_callback' );
    
    /**
        * Registers block patterns categories, and type.
    */
    
    function blockstarter_register_block_patterns() {
        $block_pattern_categories = array(
		'blockstarter' => array( 'label' => esc_html__( 'Blockstarter', 'blockstarter' ) ),
        );
        
        $block_pattern_categories = apply_filters( 'blockstarter_block_pattern_categories', $block_pattern_categories );
        
        foreach ( $block_pattern_categories as $name => $properties ) {
            if ( ! WP_Block_Pattern_Categories_Registry::get_instance()->is_registered( $name ) ) {
                register_block_pattern_category( $name, $properties );
            }
        }
    }
    add_action( 'init', 'blockstarter_register_block_patterns', 9 );
    
    /* Add custom body class based on the style variation */
    function blockstarter_body_classes( $classes ) {
        $style_variation = wp_get_global_settings( array( 'custom', 'variation' ) );
        if ( 'default' !== $style_variation ) {
            $classes[] = 'variation-' . $style_variation;
        }
        return $classes;
    }
    add_filter( 'body_class', 'blockstarter_body_classes' );
    
    /**
        * Add block style variations.
    */
    function blockstarter_register_block_styles() {
        
        $block_styles = array(
		'core/query'            => array(
        'left-featured-image' => __( 'Left Featured Image', 'blockstarter' ),
        ),
		'core/post-terms'       => array(
        'term-button' => __( 'Button Style', 'blockstarter' ),
        ),
		'core/query-pagination' => array(
        'pagination-button' => __( 'Button Style', 'blockstarter' ),
        ),
        );
        
        foreach ( $block_styles as $block => $styles ) {
            foreach ( $styles as $style_name => $style_label ) {
                register_block_style(
				$block,
				array(
                'name'  => $style_name,
                'label' => $style_label,
                )
                );
            }
        }
    }
    add_action( 'init', 'blockstarter_register_block_styles' );
    
    /**
        * Load custom block styles only when the block is used.
    */
    function blockstarter_enqueue_custom_block_styles() {
        
        // Scan our css folder to locate block styles.
        $files = glob( get_template_directory() . '/assets/css/*.css' );
        
        foreach ( $files as $file ) {
            
            // Get the filename and core block name.
            $filename   = basename( $file, '.css' );
            $block_name = str_replace( 'core-', 'core/', $filename );
            
            wp_enqueue_block_style(
			$block_name,
			array(
            'handle' => "blockstarter-block-{$filename}",
            'src'    => get_theme_file_uri( "assets/css/{$filename}.css" ),
            'path'   => get_theme_file_path( "assets/css/{$filename}.css" ),
            )
            );
        }
    }
    add_action( 'init', 'blockstarter_enqueue_custom_block_styles' );
    
    
    /**
        * My Js Shit //lololololololollolololollolololololollololollololollolol//
    */
    function wpcom_javascript() {
    ?>
    <script>
        
        
        /*Pre Loader Animation*/
        
        
        document.onreadystatechange = function() {
            if (document.readyState !== "complete") {
                document.querySelector(
                "body").style.display = "hidden";
                document.querySelector(
                "#spinner-wrapper").style.visibility = "flex";
                try {
                    document.querySelector(
                    "#topbgindex").style.height = "600px";
                    } catch (error) {
                    console.error(error);
                }
                try {
                    document.querySelector(
                    "#topbgteam").style.height = "600px";
                    } catch (error) {
                    console.error(error);
                }
                try {
                    document.querySelector(
                    "#topbgacco").style.height = "600px";
                    } catch (error) {
                    console.error(error);
                }
                try {
                    document.querySelector(
                    "#topbgschedule").style.height = "600px";
                    } catch (error) {
                    console.error(error);
                }
                try {
                    document.querySelector(
                    "#topbgevents").style.height = "600px";
                    } catch (error) {
                    console.error(error);
                }
                } else {
                document.querySelector(
                "#spinner-wrapper").style.display = "none";
                document.querySelector(
                "body").style.visibility = "visible";
                
                try {
                    document.querySelector(
                    "#topbgindex").style.height = "400px";
                    } catch (error) {
                    console.error(error);
                }
                try {
                    document.querySelector(
                    "#topbgteam").style.height = "400px";
                    } catch (error) {
                    console.error(error);
                }
                try {
                    document.querySelector(
                    "#topbgacco").style.height = "400px";
                    } catch (error) {
                    console.error(error);
                }
                try {
                    document.querySelector(
                    "#topbgschedule").style.height = "400px";
                    } catch (error) {
                    console.error(error);
                }
                try {
                    document.querySelector(
                    "#topbgevents").style.height = "400px";
                    } catch (error) {
                    console.error(error);
                }
            };
        }
        
        
        
        
        
        /*Header Background on Hover*/
        
        
        function chbg(color) {
            document.getElementById("hf").style.backgroundColor = color;
        }  
        function chb(color) {
            document.getElementById("topshit").style.backgroundColor = color;
        }   
        
        
        //var opencont = document.getElementById("mapdiv");
        var isOpen = false;
        
        const oneline=document.getElementsByClassName("btnlineone");
        const twoline=document.getElementsByClassName("btnlinetwo");
        const threeline=document.getElementsByClassName("btnlinethree");
        const headershort=document.getElementsByClassName("headershort");
        
        function toggleshort() {
            if (isOpen) {
                //close
                for (var i = 0; i < headershort.length; i++){
                    headershort[i].style.height = "0"; 
                    headershort[i].style.borderStyle = "";
                }
                for (var i = 0; i < oneline.length; i++){
                    oneline[i].classList.remove("btnoneaft");
                    oneline[i].classList.add("btnonebef");
                    for (var i = 0; i < twoline.length; i++) {
                        twoline[i].classList.remove("btntwoaft");
                    twoline[i].classList.add("btntwobef"); }
                    for (var i = 0; i < threeline.length; i++) {
                        threeline[i].classList.remove("btnthreeaft");
                    threeline[i].classList.add("btnthreebef"); }
                }
                } else {
                //open
                for (var i = 0; i < headershort.length; i++){
                    headershort[i].style.height = "310px";
                    headershort[i].style.borderStyle = "solid";
                }
                for (var i = 0; i < oneline.length; i++) {
                    oneline[i].classList.remove("btnonebef");
                oneline[i].classList.add("btnoneaft"); }
                for (var i = 0; i < twoline.length; i++) {
                    twoline[i].classList.remove("btntwobef");
                twoline[i].classList.add("btntwoaft"); }
                for (var i = 0; i < threeline.length; i++) {
                    threeline[i].classList.remove("btnthreebef");
                threeline[i].classList.add("btnthreeaft"); }
                
                
            }
            
            isOpen = !isOpen;
        }
        
        
        /* Map show hide 
            
            document.getElementById("showmap").innerHTML = "Click me to toggle map!"; 	 x.classList.toggle("showhide"); //check location of this line
            
            var elems = document.getElementsByClassName("wp-block-jetpack-map__mb-container");
            
            for (var i = 0; i < elems.length; i++)
            elems[i].style.height = "50vh";
            
            function showfootermap() {
            
            var x = document.getElementById("mapdiv");
            var elems = document.getElementsByClassName("wp-block-jetpack-map__mb-container");
            
            
            for (var i = 0; i < elems.length; i++) {
            elems[i].style.height = "50vh";
            elems[i].style.borderRadius = "25px";} 
            
            
            if (x.style.display === "none") {
            x.style.display = "block";
            } else {
            x.style.display = "none";
            }
            }
            
        */
        
    </script>
    <?php
        if (is_front_page() ) {
            
        ?>
        <script>
            /*Scroll onVisible Index*/
            
            
            var EventListener = function(element, callback) {
                this._el = element;
                this._cb = callback;
                this._at = false;
                this._hasBeenVisible = false;
                this._hasBeenInvisible = true;
                var  _me = this;
                
                window.onscroll = function() {
                    for (q in EventListener.queue.onvisible) {
                        EventListener.queue.onvisible[q].call();
                    }
                    for (q in EventListener.queue.oninvisible) {
                        EventListener.queue.oninvisible[q].call();
                    }
                };
                
                return {
                    onvisible: function() {
                        EventListener.queue.onvisible.push(function() {
                            if (!_me._at && _me._hasBeenInvisible && (window.pageYOffset + window.innerHeight) > _me._el.offsetTop && window.pageYOffset < (_me._el.offsetTop + _me._el.scrollHeight)) {
                                _me._cb.call();
                                _me._at = true;
                                _me._hasBeenVisible = true;
                            }
                        });
                        EventListener.queue.oninvisible.push(function() {
                            if (_me._hasBeenVisible && ((window.pageYOffset + window.innerHeight) < _me._el.offsetTop || window.pageYOffset > (_me._el.offsetTop + _me._el.scrollHeight))) {
                                _me._hasBeenInvisible = true;
                                _me._hasBeenVisible   = false;
                                _me._at = false;
                            }
                        });
                    },
                    oninvisible: function() {
                        EventListener.queue.oninvisible.push(function() {
                            if (!_me._at && _me._hasBeenVisible && ((window.pageYOffset + window.innerHeight) < _me._el.offsetTop || window.pageYOffset > (_me._el.offsetTop + _me._el.scrollHeight))) {
                                _me._cb.call();
                                _me._at = true;
                                _me._hasBeenInvisible = true;
                            }
                        });
                        EventListener.queue.onvisible.push(function() {
                            if (_me._hasBeenInvisible && (window.pageYOffset + window.innerHeight) > _me._el.offsetTop && window.pageYOffset < (_me._el.offsetTop + _me._el.scrollHeight)) {
                                _me._hasBeenVisible = true;
                                _me._hasBeenInvisible = false;
                                _me._at = false;
                            }
                        });
                    }
                };
            }
            EventListener.queue = {
                onvisible:   [],
                oninvisible: []
            };
            
            function addListener(element, event, fn) {
                element = document.getElementById(element);
                
                var listener = new EventListener(element, fn);
                
                if (listener['on' + event.toLowerCase()])
                return listener['on' + event.toLowerCase()].call();
            }
            
            
            
            window.onload = function() {
                
                /* try {
                    addListener('goldborder1', 'visible', function() {
                    document.getElementById("topgoldborder1").style.width = "calc((100%) + 30px)";
                    document.getElementById("bottomgoldborder1").style.width = "calc((100%) + 30px)";
                    document.getElementById("leftgoldborder1").style.height = "calc((100%) + 30px)";
                    document.getElementById("rightgoldborder1").style.height = "calc((100%) + 30px)";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    try {
                    addListener('goldborder2', 'visible', function() {
                    document.getElementById("topgoldborder2").style.width = "calc((100%) + 30px)";
                    document.getElementById("bottomgoldborder2").style.width = "calc((100%) + 30px)";
                    document.getElementById("leftgoldborder2").style.height = "calc((100%) + 30px)";
                    document.getElementById("rightgoldborder2").style.height = "calc((100%) + 30px)";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    try {
                    addListener('goldborder3', 'visible', function() {
                    document.getElementById("topgoldborder3").style.width = "calc((100%) + 30px)";
                    document.getElementById("bottomgoldborder3").style.width = "calc((100%) + 30px)";
                    document.getElementById("leftgoldborder3").style.height = "calc((100%) + 30px)";
                    document.getElementById("rightgoldborder3").style.height = "calc((100%) + 30px)";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('goldborder1', 'invisible', function() {
                    document.getElementById("topgoldborder1").style.width = "0";
                    document.getElementById("bottomgoldborder1").style.width = "0";
                    document.getElementById("leftgoldborder1").style.height = "0";
                    document.getElementById("rightgoldborder1").style.height = "0";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('goldborder2', 'invisible', function() {
                    document.getElementById("topgoldborder2").style.width = "0";
                    document.getElementById("bottomgoldborder2").style.width = "0";
                    document.getElementById("leftgoldborder2").style.height = "0";
                    document.getElementById("rightgoldborder2").style.height = "0";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('goldborder3', 'invisible', function() {
                    document.getElementById("topgoldborder3").style.width = "0";
                    document.getElementById("bottomgoldborder3").style.width = "0";
                    document.getElementById("leftgoldborder3").style.height = "0";
                    document.getElementById("rightgoldborder3").style.height = "0";
                    });
                    } catch (error) {
                    onsole.error(error);
                } */
                
                
                /*                 let slideIndex = 0;
                    showSlides();
                */
                let slideIndex = 1;
                showSlides(slideIndex);
                slideShow();
                
                
                function showSlides(n) {
                    let i;
                    let slides = document.getElementsByClassName("mySlides");
                    let dots = document.getElementsByClassName("dot");
                    if (n > slides.length) {slideIndex = 1}    
                    if (n < 1) {slideIndex = slides.length}
                    for (i = 0; i < slides.length; i++) {
                        slides[i].style.display = "none";  
                    }
                    for (i = 0; i < dots.length; i++) {
                        dots[i].className = dots[i].className.replace(" active", "");
                    }
                    slides[slideIndex-1].style.display = "block";  
                    dots[slideIndex-1].className += " active";
                }
                
                function slideShow () {
                    plusSlides(1)
                    setTimeout(slideShow, 5000);
                    
                }
                
                var ps = document.getElementById("ps");
                var ns = document.getElementById("ns");
                
                ps.onclick = function (e) {
                    plusSlides(-1);
                };
                
                ns.onclick = function (e) {
                    plusSlides(1)
                };
                
                function plusSlides(n) {
                    showSlides(slideIndex += n);
                }
                
                //width anims for dividers
                
                try {
                    addListener('divider1', 'visible', function() {
                        document.getElementById("divider1").style.width = "60%";
                    });
                    } catch (error) {
                    console.error(error);
                }
                
                
                try {
                    addListener('divider1', 'invisible', function() {
                        document.getElementById("divider1").style.width = "0";
                    });
                    } catch (error) {
                    console.error(error);
                }
                
                
                try {
                    addListener('divider2', 'visible', function() {
                        document.getElementById("divider2").style.width = "60%";
                    });
                    } catch (error) {
                    console.error(error);
                }
                
                
                
                try {
                    addListener('divider2', 'invisible', function() {
                        document.getElementById("divider2").style.width = "0";
                    });
                    } catch (error) {
                    console.error(error);
                }
                
                // try {
                // addListener('divider3', 'visible', function() {
                // document.getElementById("divider3").style.width = "60%";
                // });
                // } catch (error) {
                // console.error(error);
                // }
                
                
                
                // try {
                // addListener('divider3', 'invisible', function() {
                // document.getElementById("divider3").style.width = "0";
                // });
                // } catch (error) {
                // console.error(error);
                // }
                
                // try {
                // addListener('divider4', 'visible', function() {
                // document.getElementById("divider4").style.width = "60%";
                // });
                // } catch (error) {
                // console.error(error);
                // }
                
                
                
                // try {
                // addListener('divider4', 'invisible', function() {
                // document.getElementById("divider4").style.width = "0";
                // });
                // } catch (error) {
                // console.error(error);
                // }
                
            }
            
        </script>
        <?php
        }
        
        if (is_page('Team - Silhouettes') ) {
            
        ?>
        <script>
            /*Scroll onVisible team*/
            
            
            var EventListener = function(element, callback) {
                this._el = element;
                this._cb = callback;
                this._at = false;
                this._hasBeenVisible = false;
                this._hasBeenInvisible = true;
                var  _me = this;
                
                window.onscroll = function() {
                    for (q in EventListener.queue.onvisible) {
                        EventListener.queue.onvisible[q].call();
                    }
                    for (q in EventListener.queue.oninvisible) {
                        EventListener.queue.oninvisible[q].call();
                    }
                };
                
                return {
                    onvisible: function() {
                        EventListener.queue.onvisible.push(function() {
                            if (!_me._at && _me._hasBeenInvisible && (window.pageYOffset + window.innerHeight) > _me._el.offsetTop && window.pageYOffset < (_me._el.offsetTop + _me._el.scrollHeight)) {
                                _me._cb.call();
                                _me._at = true;
                                _me._hasBeenVisible = true;
                            }
                        });
                        EventListener.queue.oninvisible.push(function() {
                            if (_me._hasBeenVisible && ((window.pageYOffset + window.innerHeight) < _me._el.offsetTop || window.pageYOffset > (_me._el.offsetTop + _me._el.scrollHeight))) {
                                _me._hasBeenInvisible = true;
                                _me._hasBeenVisible   = false;
                                _me._at = false;
                            }
                        });
                    },
                    oninvisible: function() {
                        EventListener.queue.oninvisible.push(function() {
                            if (!_me._at && _me._hasBeenVisible && ((window.pageYOffset + window.innerHeight) < _me._el.offsetTop || window.pageYOffset > (_me._el.offsetTop + _me._el.scrollHeight))) {
                                _me._cb.call();
                                _me._at = true;
                                _me._hasBeenInvisible = true;
                            }
                        });
                        EventListener.queue.onvisible.push(function() {
                            if (_me._hasBeenInvisible && (window.pageYOffset + window.innerHeight) > _me._el.offsetTop && window.pageYOffset < (_me._el.offsetTop + _me._el.scrollHeight)) {
                                _me._hasBeenVisible = true;
                                _me._hasBeenInvisible = false;
                                _me._at = false;
                            }
                        });
                    }
                };
            }
            EventListener.queue = {
                onvisible:   [],
                oninvisible: []
            };
            
            function addListener(element, event, fn) {
                element = document.getElementById(element);
                
                var listener = new EventListener(element, fn);
                
                if (listener['on' + event.toLowerCase()])
                return listener['on' + event.toLowerCase()].call();
            }
            
            window.onload = function() {
                
                /* try {
                    addListener('goldborder1', 'visible', function() {
                    document.getElementById("topgoldborder1").style.width = "calc((100%) + 30px)";
                    document.getElementById("bottomgoldborder1").style.width = "calc((100%) + 30px)";
                    document.getElementById("leftgoldborder1").style.height = "calc((100%) + 30px)";
                    document.getElementById("rightgoldborder1").style.height = "calc((100%) + 30px)";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    try {
                    addListener('goldborder2', 'visible', function() {
                    document.getElementById("topgoldborder2").style.width = "calc((100%) + 30px)";
                    document.getElementById("bottomgoldborder2").style.width = "calc((100%) + 30px)";
                    document.getElementById("leftgoldborder2").style.height = "calc((100%) + 30px)";
                    document.getElementById("rightgoldborder2").style.height = "calc((100%) + 30px)";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    try {
                    addListener('goldborder3', 'visible', function() {
                    document.getElementById("topgoldborder3").style.width = "calc((100%) + 30px)";
                    document.getElementById("bottomgoldborder3").style.width = "calc((100%) + 30px)";
                    document.getElementById("leftgoldborder3").style.height = "calc((100%) + 30px)";
                    document.getElementById("rightgoldborder3").style.height = "calc((100%) + 30px)";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('goldborder1', 'invisible', function() {
                    document.getElementById("topgoldborder1").style.width = "0";
                    document.getElementById("bottomgoldborder1").style.width = "0";
                    document.getElementById("leftgoldborder1").style.height = "0";
                    document.getElementById("rightgoldborder1").style.height = "0";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('goldborder2', 'invisible', function() {
                    document.getElementById("topgoldborder2").style.width = "0";
                    document.getElementById("bottomgoldborder2").style.width = "0";
                    document.getElementById("leftgoldborder2").style.height = "0";
                    document.getElementById("rightgoldborder2").style.height = "0";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('goldborder3', 'invisible', function() {
                    document.getElementById("topgoldborder3").style.width = "0";
                    document.getElementById("bottomgoldborder3").style.width = "0";
                    document.getElementById("leftgoldborder3").style.height = "0";
                    document.getElementById("rightgoldborder3").style.height = "0";
                    });
                    } catch (error) {
                    onsole.error(error);
                } */
                
                
                
                //width anims for dividers
                
                try {
                    addListener('divider1', 'visible', function() {
                        document.getElementById("divider1").style.width = "60%";
                    });
                    } catch (error) {
                    console.error(error);
                }
                
                
                try {
                    addListener('divider1', 'invisible', function() {
                        document.getElementById("divider1").style.width = "0";
                    });
                    } catch (error) {
                    console.error(error);
                }
                
                
                /* try {
                    addListener('divider2', 'visible', function() {
                    document.getElementById("divider2").style.width = "60%";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('divider2', 'invisible', function() {
                    document.getElementById("divider2").style.width = "0";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                */
            }
            
            
        </script>
        <?php
        }
        
        if (is_page('Accommodation - Silhouettes') ) {
            
        ?>
        <script>
            /*Scroll onVisible team*/
            
            
            var EventListener = function(element, callback) {
                this._el = element;
                this._cb = callback;
                this._at = false;
                this._hasBeenVisible = false;
                this._hasBeenInvisible = true;
                var  _me = this;
                
                window.onscroll = function() {
                    for (q in EventListener.queue.onvisible) {
                        EventListener.queue.onvisible[q].call();
                    }
                    for (q in EventListener.queue.oninvisible) {
                        EventListener.queue.oninvisible[q].call();
                    }
                };
                
                return {
                    onvisible: function() {
                        EventListener.queue.onvisible.push(function() {
                            if (!_me._at && _me._hasBeenInvisible && (window.pageYOffset + window.innerHeight) > _me._el.offsetTop && window.pageYOffset < (_me._el.offsetTop + _me._el.scrollHeight)) {
                                _me._cb.call();
                                _me._at = true;
                                _me._hasBeenVisible = true;
                            }
                        });
                        EventListener.queue.oninvisible.push(function() {
                            if (_me._hasBeenVisible && ((window.pageYOffset + window.innerHeight) < _me._el.offsetTop || window.pageYOffset > (_me._el.offsetTop + _me._el.scrollHeight))) {
                                _me._hasBeenInvisible = true;
                                _me._hasBeenVisible   = false;
                                _me._at = false;
                            }
                        });
                    },
                    oninvisible: function() {
                        EventListener.queue.oninvisible.push(function() {
                            if (!_me._at && _me._hasBeenVisible && ((window.pageYOffset + window.innerHeight) < _me._el.offsetTop || window.pageYOffset > (_me._el.offsetTop + _me._el.scrollHeight))) {
                                _me._cb.call();
                                _me._at = true;
                                _me._hasBeenInvisible = true;
                            }
                        });
                        EventListener.queue.onvisible.push(function() {
                            if (_me._hasBeenInvisible && (window.pageYOffset + window.innerHeight) > _me._el.offsetTop && window.pageYOffset < (_me._el.offsetTop + _me._el.scrollHeight)) {
                                _me._hasBeenVisible = true;
                                _me._hasBeenInvisible = false;
                                _me._at = false;
                            }
                        });
                    }
                };
            }
            EventListener.queue = {
                onvisible:   [],
                oninvisible: []
            };
            
            function addListener(element, event, fn) {
                element = document.getElementById(element);
                
                var listener = new EventListener(element, fn);
                
                if (listener['on' + event.toLowerCase()])
                return listener['on' + event.toLowerCase()].call();
            }
            
            window.onload = function() {
                
                /* try {
                    addListener('goldborder1', 'visible', function() {
                    document.getElementById("topgoldborder1").style.width = "calc((100%) + 30px)";
                    document.getElementById("bottomgoldborder1").style.width = "calc((100%) + 30px)";
                    document.getElementById("leftgoldborder1").style.height = "calc((100%) + 30px)";
                    document.getElementById("rightgoldborder1").style.height = "calc((100%) + 30px)";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    try {
                    addListener('goldborder2', 'visible', function() {
                    document.getElementById("topgoldborder2").style.width = "calc((100%) + 30px)";
                    document.getElementById("bottomgoldborder2").style.width = "calc((100%) + 30px)";
                    document.getElementById("leftgoldborder2").style.height = "calc((100%) + 30px)";
                    document.getElementById("rightgoldborder2").style.height = "calc((100%) + 30px)";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    try {
                    addListener('goldborder3', 'visible', function() {
                    document.getElementById("topgoldborder3").style.width = "calc((100%) + 30px)";
                    document.getElementById("bottomgoldborder3").style.width = "calc((100%) + 30px)";
                    document.getElementById("leftgoldborder3").style.height = "calc((100%) + 30px)";
                    document.getElementById("rightgoldborder3").style.height = "calc((100%) + 30px)";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('goldborder1', 'invisible', function() {
                    document.getElementById("topgoldborder1").style.width = "0";
                    document.getElementById("bottomgoldborder1").style.width = "0";
                    document.getElementById("leftgoldborder1").style.height = "0";
                    document.getElementById("rightgoldborder1").style.height = "0";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('goldborder2', 'invisible', function() {
                    document.getElementById("topgoldborder2").style.width = "0";
                    document.getElementById("bottomgoldborder2").style.width = "0";
                    document.getElementById("leftgoldborder2").style.height = "0";
                    document.getElementById("rightgoldborder2").style.height = "0";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('goldborder3', 'invisible', function() {
                    document.getElementById("topgoldborder3").style.width = "0";
                    document.getElementById("bottomgoldborder3").style.width = "0";
                    document.getElementById("leftgoldborder3").style.height = "0";
                    document.getElementById("rightgoldborder3").style.height = "0";
                    });
                    } catch (error) {
                    onsole.error(error);
                } */
                
                
                
                //width anims for dividers
                
                try {
                    addListener('divider1', 'visible', function() {
                        document.getElementById("divider1").style.width = "60%";
                    });
                    } catch (error) {
                    console.error(error);
                }
                
                
                try {
                    addListener('divider1', 'invisible', function() {
                        document.getElementById("divider1").style.width = "0";
                    });
                    } catch (error) {
                    console.error(error);
                }
                
                
                /* try {
                    addListener('divider2', 'visible', function() {
                    document.getElementById("divider2").style.width = "60%";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('divider2', 'invisible', function() {
                    document.getElementById("divider2").style.width = "0";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                */
            }
            
            
        </script>
        <?php
        }
        
        if (is_page('Literary - Events') ) {
            
        ?>
        <script>
            /*Scroll onVisible team*/
            
            
            var EventListener = function(element, callback) {
                this._el = element;
                this._cb = callback;
                this._at = false;
                this._hasBeenVisible = false;
                this._hasBeenInvisible = true;
                var  _me = this;
                
                window.onscroll = function() {
                    for (q in EventListener.queue.onvisible) {
                        EventListener.queue.onvisible[q].call();
                    }
                    for (q in EventListener.queue.oninvisible) {
                        EventListener.queue.oninvisible[q].call();
                    }
                };
                
                return {
                    onvisible: function() {
                        EventListener.queue.onvisible.push(function() {
                            if (!_me._at && _me._hasBeenInvisible && (window.pageYOffset + window.innerHeight) > _me._el.offsetTop && window.pageYOffset < (_me._el.offsetTop + _me._el.scrollHeight)) {
                                _me._cb.call();
                                _me._at = true;
                                _me._hasBeenVisible = true;
                            }
                        });
                        EventListener.queue.oninvisible.push(function() {
                            if (_me._hasBeenVisible && ((window.pageYOffset + window.innerHeight) < _me._el.offsetTop || window.pageYOffset > (_me._el.offsetTop + _me._el.scrollHeight))) {
                                _me._hasBeenInvisible = true;
                                _me._hasBeenVisible   = false;
                                _me._at = false;
                            }
                        });
                    },
                    oninvisible: function() {
                        EventListener.queue.oninvisible.push(function() {
                            if (!_me._at && _me._hasBeenVisible && ((window.pageYOffset + window.innerHeight) < _me._el.offsetTop || window.pageYOffset > (_me._el.offsetTop + _me._el.scrollHeight))) {
                                _me._cb.call();
                                _me._at = true;
                                _me._hasBeenInvisible = true;
                            }
                        });
                        EventListener.queue.onvisible.push(function() {
                            if (_me._hasBeenInvisible && (window.pageYOffset + window.innerHeight) > _me._el.offsetTop && window.pageYOffset < (_me._el.offsetTop + _me._el.scrollHeight)) {
                                _me._hasBeenVisible = true;
                                _me._hasBeenInvisible = false;
                                _me._at = false;
                            }
                        });
                    }
                };
            }
            EventListener.queue = {
                onvisible:   [],
                oninvisible: []
            };
            
            function addListener(element, event, fn) {
                element = document.getElementById(element);
                
                var listener = new EventListener(element, fn);
                
                if (listener['on' + event.toLowerCase()])
                return listener['on' + event.toLowerCase()].call();
            }
            
            window.onload = function() {
                
                /* try {
                    addListener('goldborder1', 'visible', function() {
                    document.getElementById("topgoldborder1").style.width = "calc((100%) + 30px)";
                    document.getElementById("bottomgoldborder1").style.width = "calc((100%) + 30px)";
                    document.getElementById("leftgoldborder1").style.height = "calc((100%) + 30px)";
                    document.getElementById("rightgoldborder1").style.height = "calc((100%) + 30px)";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    try {
                    addListener('goldborder2', 'visible', function() {
                    document.getElementById("topgoldborder2").style.width = "calc((100%) + 30px)";
                    document.getElementById("bottomgoldborder2").style.width = "calc((100%) + 30px)";
                    document.getElementById("leftgoldborder2").style.height = "calc((100%) + 30px)";
                    document.getElementById("rightgoldborder2").style.height = "calc((100%) + 30px)";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    try {
                    addListener('goldborder3', 'visible', function() {
                    document.getElementById("topgoldborder3").style.width = "calc((100%) + 30px)";
                    document.getElementById("bottomgoldborder3").style.width = "calc((100%) + 30px)";
                    document.getElementById("leftgoldborder3").style.height = "calc((100%) + 30px)";
                    document.getElementById("rightgoldborder3").style.height = "calc((100%) + 30px)";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('goldborder1', 'invisible', function() {
                    document.getElementById("topgoldborder1").style.width = "0";
                    document.getElementById("bottomgoldborder1").style.width = "0";
                    document.getElementById("leftgoldborder1").style.height = "0";
                    document.getElementById("rightgoldborder1").style.height = "0";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('goldborder2', 'invisible', function() {
                    document.getElementById("topgoldborder2").style.width = "0";
                    document.getElementById("bottomgoldborder2").style.width = "0";
                    document.getElementById("leftgoldborder2").style.height = "0";
                    document.getElementById("rightgoldborder2").style.height = "0";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('goldborder3', 'invisible', function() {
                    document.getElementById("topgoldborder3").style.width = "0";
                    document.getElementById("bottomgoldborder3").style.width = "0";
                    document.getElementById("leftgoldborder3").style.height = "0";
                    document.getElementById("rightgoldborder3").style.height = "0";
                    });
                    } catch (error) {
                    onsole.error(error);
                } */
                
                
                
                //width anims for dividers
                
                try {
                    addListener('divider1', 'visible', function() {
                        document.getElementById("divider1").style.width = "60%";
                    });
                    } catch (error) {
                    console.error(error);
                }
                
                
                try {
                    addListener('divider1', 'invisible', function() {
                        document.getElementById("divider1").style.width = "0";
                    });
                    } catch (error) {
                    console.error(error);
                }
                
                
                /* try {
                    addListener('divider2', 'visible', function() {
                    document.getElementById("divider2").style.width = "60%";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('divider2', 'invisible', function() {
                    document.getElementById("divider2").style.width = "0";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                */
            }
            
            
        </script>
        <?php
        }
        
        if (is_page('Sports - Events') ) {
            
        ?>
        <script>
            /*Scroll onVisible team*/
            
            
            var EventListener = function(element, callback) {
                this._el = element;
                this._cb = callback;
                this._at = false;
                this._hasBeenVisible = false;
                this._hasBeenInvisible = true;
                var  _me = this;
                
                window.onscroll = function() {
                    for (q in EventListener.queue.onvisible) {
                        EventListener.queue.onvisible[q].call();
                    }
                    for (q in EventListener.queue.oninvisible) {
                        EventListener.queue.oninvisible[q].call();
                    }
                };
                
                return {
                    onvisible: function() {
                        EventListener.queue.onvisible.push(function() {
                            if (!_me._at && _me._hasBeenInvisible && (window.pageYOffset + window.innerHeight) > _me._el.offsetTop && window.pageYOffset < (_me._el.offsetTop + _me._el.scrollHeight)) {
                                _me._cb.call();
                                _me._at = true;
                                _me._hasBeenVisible = true;
                            }
                        });
                        EventListener.queue.oninvisible.push(function() {
                            if (_me._hasBeenVisible && ((window.pageYOffset + window.innerHeight) < _me._el.offsetTop || window.pageYOffset > (_me._el.offsetTop + _me._el.scrollHeight))) {
                                _me._hasBeenInvisible = true;
                                _me._hasBeenVisible   = false;
                                _me._at = false;
                            }
                        });
                    },
                    oninvisible: function() {
                        EventListener.queue.oninvisible.push(function() {
                            if (!_me._at && _me._hasBeenVisible && ((window.pageYOffset + window.innerHeight) < _me._el.offsetTop || window.pageYOffset > (_me._el.offsetTop + _me._el.scrollHeight))) {
                                _me._cb.call();
                                _me._at = true;
                                _me._hasBeenInvisible = true;
                            }
                        });
                        EventListener.queue.onvisible.push(function() {
                            if (_me._hasBeenInvisible && (window.pageYOffset + window.innerHeight) > _me._el.offsetTop && window.pageYOffset < (_me._el.offsetTop + _me._el.scrollHeight)) {
                                _me._hasBeenVisible = true;
                                _me._hasBeenInvisible = false;
                                _me._at = false;
                            }
                        });
                    }
                };
            }
            EventListener.queue = {
                onvisible:   [],
                oninvisible: []
            };
            
            function addListener(element, event, fn) {
                element = document.getElementById(element);
                
                var listener = new EventListener(element, fn);
                
                if (listener['on' + event.toLowerCase()])
                return listener['on' + event.toLowerCase()].call();
            }
            
            window.onload = function() {
                
                /* try {
                    addListener('goldborder1', 'visible', function() {
                    document.getElementById("topgoldborder1").style.width = "calc((100%) + 30px)";
                    document.getElementById("bottomgoldborder1").style.width = "calc((100%) + 30px)";
                    document.getElementById("leftgoldborder1").style.height = "calc((100%) + 30px)";
                    document.getElementById("rightgoldborder1").style.height = "calc((100%) + 30px)";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    try {
                    addListener('goldborder2', 'visible', function() {
                    document.getElementById("topgoldborder2").style.width = "calc((100%) + 30px)";
                    document.getElementById("bottomgoldborder2").style.width = "calc((100%) + 30px)";
                    document.getElementById("leftgoldborder2").style.height = "calc((100%) + 30px)";
                    document.getElementById("rightgoldborder2").style.height = "calc((100%) + 30px)";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    try {
                    addListener('goldborder3', 'visible', function() {
                    document.getElementById("topgoldborder3").style.width = "calc((100%) + 30px)";
                    document.getElementById("bottomgoldborder3").style.width = "calc((100%) + 30px)";
                    document.getElementById("leftgoldborder3").style.height = "calc((100%) + 30px)";
                    document.getElementById("rightgoldborder3").style.height = "calc((100%) + 30px)";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('goldborder1', 'invisible', function() {
                    document.getElementById("topgoldborder1").style.width = "0";
                    document.getElementById("bottomgoldborder1").style.width = "0";
                    document.getElementById("leftgoldborder1").style.height = "0";
                    document.getElementById("rightgoldborder1").style.height = "0";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('goldborder2', 'invisible', function() {
                    document.getElementById("topgoldborder2").style.width = "0";
                    document.getElementById("bottomgoldborder2").style.width = "0";
                    document.getElementById("leftgoldborder2").style.height = "0";
                    document.getElementById("rightgoldborder2").style.height = "0";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('goldborder3', 'invisible', function() {
                    document.getElementById("topgoldborder3").style.width = "0";
                    document.getElementById("bottomgoldborder3").style.width = "0";
                    document.getElementById("leftgoldborder3").style.height = "0";
                    document.getElementById("rightgoldborder3").style.height = "0";
                    });
                    } catch (error) {
                    onsole.error(error);
                } */
                
                
                
                //width anims for dividers
                
                try {
                    addListener('divider1', 'visible', function() {
                        document.getElementById("divider1").style.width = "60%";
                    });
                    } catch (error) {
                    console.error(error);
                }
                
                
                try {
                    addListener('divider1', 'invisible', function() {
                        document.getElementById("divider1").style.width = "0";
                    });
                    } catch (error) {
                    console.error(error);
                }
                
                
                /* try {
                    addListener('divider2', 'visible', function() {
                    document.getElementById("divider2").style.width = "60%";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('divider2', 'invisible', function() {
                    document.getElementById("divider2").style.width = "0";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                */
            }
            
            
        </script>
        <?php
        }
        
        if (is_page('Culturals - Events') ) {
            
        ?>
        <script>
            /*Scroll onVisible team*/
            
            
            var EventListener = function(element, callback) {
                this._el = element;
                this._cb = callback;
                this._at = false;
                this._hasBeenVisible = false;
                this._hasBeenInvisible = true;
                var  _me = this;
                
                window.onscroll = function() {
                    for (q in EventListener.queue.onvisible) {
                        EventListener.queue.onvisible[q].call();
                    }
                    for (q in EventListener.queue.oninvisible) {
                        EventListener.queue.oninvisible[q].call();
                    }
                };
                
                return {
                    onvisible: function() {
                        EventListener.queue.onvisible.push(function() {
                            if (!_me._at && _me._hasBeenInvisible && (window.pageYOffset + window.innerHeight) > _me._el.offsetTop && window.pageYOffset < (_me._el.offsetTop + _me._el.scrollHeight)) {
                                _me._cb.call();
                                _me._at = true;
                                _me._hasBeenVisible = true;
                            }
                        });
                        EventListener.queue.oninvisible.push(function() {
                            if (_me._hasBeenVisible && ((window.pageYOffset + window.innerHeight) < _me._el.offsetTop || window.pageYOffset > (_me._el.offsetTop + _me._el.scrollHeight))) {
                                _me._hasBeenInvisible = true;
                                _me._hasBeenVisible   = false;
                                _me._at = false;
                            }
                        });
                    },
                    oninvisible: function() {
                        EventListener.queue.oninvisible.push(function() {
                            if (!_me._at && _me._hasBeenVisible && ((window.pageYOffset + window.innerHeight) < _me._el.offsetTop || window.pageYOffset > (_me._el.offsetTop + _me._el.scrollHeight))) {
                                _me._cb.call();
                                _me._at = true;
                                _me._hasBeenInvisible = true;
                            }
                        });
                        EventListener.queue.onvisible.push(function() {
                            if (_me._hasBeenInvisible && (window.pageYOffset + window.innerHeight) > _me._el.offsetTop && window.pageYOffset < (_me._el.offsetTop + _me._el.scrollHeight)) {
                                _me._hasBeenVisible = true;
                                _me._hasBeenInvisible = false;
                                _me._at = false;
                            }
                        });
                    }
                };
            }
            EventListener.queue = {
                onvisible:   [],
                oninvisible: []
            };
            
            function addListener(element, event, fn) {
                element = document.getElementById(element);
                
                var listener = new EventListener(element, fn);
                
                if (listener['on' + event.toLowerCase()])
                return listener['on' + event.toLowerCase()].call();
            }
            
            window.onload = function() {
                
                /* try {
                    addListener('goldborder1', 'visible', function() {
                    document.getElementById("topgoldborder1").style.width = "calc((100%) + 30px)";
                    document.getElementById("bottomgoldborder1").style.width = "calc((100%) + 30px)";
                    document.getElementById("leftgoldborder1").style.height = "calc((100%) + 30px)";
                    document.getElementById("rightgoldborder1").style.height = "calc((100%) + 30px)";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    try {
                    addListener('goldborder2', 'visible', function() {
                    document.getElementById("topgoldborder2").style.width = "calc((100%) + 30px)";
                    document.getElementById("bottomgoldborder2").style.width = "calc((100%) + 30px)";
                    document.getElementById("leftgoldborder2").style.height = "calc((100%) + 30px)";
                    document.getElementById("rightgoldborder2").style.height = "calc((100%) + 30px)";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    try {
                    addListener('goldborder3', 'visible', function() {
                    document.getElementById("topgoldborder3").style.width = "calc((100%) + 30px)";
                    document.getElementById("bottomgoldborder3").style.width = "calc((100%) + 30px)";
                    document.getElementById("leftgoldborder3").style.height = "calc((100%) + 30px)";
                    document.getElementById("rightgoldborder3").style.height = "calc((100%) + 30px)";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('goldborder1', 'invisible', function() {
                    document.getElementById("topgoldborder1").style.width = "0";
                    document.getElementById("bottomgoldborder1").style.width = "0";
                    document.getElementById("leftgoldborder1").style.height = "0";
                    document.getElementById("rightgoldborder1").style.height = "0";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('goldborder2', 'invisible', function() {
                    document.getElementById("topgoldborder2").style.width = "0";
                    document.getElementById("bottomgoldborder2").style.width = "0";
                    document.getElementById("leftgoldborder2").style.height = "0";
                    document.getElementById("rightgoldborder2").style.height = "0";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('goldborder3', 'invisible', function() {
                    document.getElementById("topgoldborder3").style.width = "0";
                    document.getElementById("bottomgoldborder3").style.width = "0";
                    document.getElementById("leftgoldborder3").style.height = "0";
                    document.getElementById("rightgoldborder3").style.height = "0";
                    });
                    } catch (error) {
                    onsole.error(error);
                } */
                
                
                
                //width anims for dividers
                
                try {
                    addListener('divider1', 'visible', function() {
                        document.getElementById("divider1").style.width = "60%";
                    });
                    } catch (error) {
                    console.error(error);
                }
                
                
                try {
                    addListener('divider1', 'invisible', function() {
                        document.getElementById("divider1").style.width = "0";
                    });
                    } catch (error) {
                    console.error(error);
                }
                
                
                /* try {
                    addListener('divider2', 'visible', function() {
                    document.getElementById("divider2").style.width = "60%";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('divider2', 'invisible', function() {
                    document.getElementById("divider2").style.width = "0";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                */
            }
            
            
        </script>
        <?php
        }
        
        if (is_page('Schedule - Silhouettes') ) {
            
        ?>
        <script>
            /*Scroll onVisible team*/
            
            
            var EventListener = function(element, callback) {
                this._el = element;
                this._cb = callback;
                this._at = false;
                this._hasBeenVisible = false;
                this._hasBeenInvisible = true;
                var  _me = this;
                
                window.onscroll = function() {
                    for (q in EventListener.queue.onvisible) {
                        EventListener.queue.onvisible[q].call();
                    }
                    for (q in EventListener.queue.oninvisible) {
                        EventListener.queue.oninvisible[q].call();
                    }
                };
                
                return {
                    onvisible: function() {
                        EventListener.queue.onvisible.push(function() {
                            if (!_me._at && _me._hasBeenInvisible && (window.pageYOffset + window.innerHeight) > _me._el.offsetTop && window.pageYOffset < (_me._el.offsetTop + _me._el.scrollHeight)) {
                                _me._cb.call();
                                _me._at = true;
                                _me._hasBeenVisible = true;
                            }
                        });
                        EventListener.queue.oninvisible.push(function() {
                            if (_me._hasBeenVisible && ((window.pageYOffset + window.innerHeight) < _me._el.offsetTop || window.pageYOffset > (_me._el.offsetTop + _me._el.scrollHeight))) {
                                _me._hasBeenInvisible = true;
                                _me._hasBeenVisible   = false;
                                _me._at = false;
                            }
                        });
                    },
                    oninvisible: function() {
                        EventListener.queue.oninvisible.push(function() {
                            if (!_me._at && _me._hasBeenVisible && ((window.pageYOffset + window.innerHeight) < _me._el.offsetTop || window.pageYOffset > (_me._el.offsetTop + _me._el.scrollHeight))) {
                                _me._cb.call();
                                _me._at = true;
                                _me._hasBeenInvisible = true;
                            }
                        });
                        EventListener.queue.onvisible.push(function() {
                            if (_me._hasBeenInvisible && (window.pageYOffset + window.innerHeight) > _me._el.offsetTop && window.pageYOffset < (_me._el.offsetTop + _me._el.scrollHeight)) {
                                _me._hasBeenVisible = true;
                                _me._hasBeenInvisible = false;
                                _me._at = false;
                            }
                        });
                    }
                };
            }
            EventListener.queue = {
                onvisible:   [],
                oninvisible: []
            };
            
            function addListener(element, event, fn) {
                element = document.getElementById(element);
                
                var listener = new EventListener(element, fn);
                
                if (listener['on' + event.toLowerCase()])
                return listener['on' + event.toLowerCase()].call();
            }
            
            window.onload = function() {
                
                /* try {
                    addListener('goldborder1', 'visible', function() {
                    document.getElementById("topgoldborder1").style.width = "calc((100%) + 30px)";
                    document.getElementById("bottomgoldborder1").style.width = "calc((100%) + 30px)";
                    document.getElementById("leftgoldborder1").style.height = "calc((100%) + 30px)";
                    document.getElementById("rightgoldborder1").style.height = "calc((100%) + 30px)";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    try {
                    addListener('goldborder2', 'visible', function() {
                    document.getElementById("topgoldborder2").style.width = "calc((100%) + 30px)";
                    document.getElementById("bottomgoldborder2").style.width = "calc((100%) + 30px)";
                    document.getElementById("leftgoldborder2").style.height = "calc((100%) + 30px)";
                    document.getElementById("rightgoldborder2").style.height = "calc((100%) + 30px)";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    try {
                    addListener('goldborder3', 'visible', function() {
                    document.getElementById("topgoldborder3").style.width = "calc((100%) + 30px)";
                    document.getElementById("bottomgoldborder3").style.width = "calc((100%) + 30px)";
                    document.getElementById("leftgoldborder3").style.height = "calc((100%) + 30px)";
                    document.getElementById("rightgoldborder3").style.height = "calc((100%) + 30px)";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('goldborder1', 'invisible', function() {
                    document.getElementById("topgoldborder1").style.width = "0";
                    document.getElementById("bottomgoldborder1").style.width = "0";
                    document.getElementById("leftgoldborder1").style.height = "0";
                    document.getElementById("rightgoldborder1").style.height = "0";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('goldborder2', 'invisible', function() {
                    document.getElementById("topgoldborder2").style.width = "0";
                    document.getElementById("bottomgoldborder2").style.width = "0";
                    document.getElementById("leftgoldborder2").style.height = "0";
                    document.getElementById("rightgoldborder2").style.height = "0";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('goldborder3', 'invisible', function() {
                    document.getElementById("topgoldborder3").style.width = "0";
                    document.getElementById("bottomgoldborder3").style.width = "0";
                    document.getElementById("leftgoldborder3").style.height = "0";
                    document.getElementById("rightgoldborder3").style.height = "0";
                    });
                    } catch (error) {
                    onsole.error(error);
                } */
                
                
                
                //width anims for dividers
                
                try {
                    addListener('divider1', 'visible', function() {
                        document.getElementById("divider1").style.width = "60%";
                    });
                    } catch (error) {
                    console.error(error);
                }
                
                
                try {
                    addListener('divider1', 'invisible', function() {
                        document.getElementById("divider1").style.width = "0";
                    });
                    } catch (error) {
                    console.error(error);
                }
                
                
                /* try {
                    addListener('divider2', 'visible', function() {
                    document.getElementById("divider2").style.width = "60%";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('divider2', 'invisible', function() {
                    document.getElementById("divider2").style.width = "0";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                */
            }
            
            
        </script>
        <?php
        }
        
        if (is_page('Events - Silhouettes') ) {
            
        ?>
        <script>
            /*Scroll onVisible team*/
            
            
            var EventListener = function(element, callback) {
                this._el = element;
                this._cb = callback;
                this._at = false;
                this._hasBeenVisible = false;
                this._hasBeenInvisible = true;
                var  _me = this;
                
                window.onscroll = function() {
                    for (q in EventListener.queue.onvisible) {
                        EventListener.queue.onvisible[q].call();
                    }
                    for (q in EventListener.queue.oninvisible) {
                        EventListener.queue.oninvisible[q].call();
                    }
                };
                
                return {
                    onvisible: function() {
                        EventListener.queue.onvisible.push(function() {
                            if (!_me._at && _me._hasBeenInvisible && (window.pageYOffset + window.innerHeight) > _me._el.offsetTop && window.pageYOffset < (_me._el.offsetTop + _me._el.scrollHeight)) {
                                _me._cb.call();
                                _me._at = true;
                                _me._hasBeenVisible = true;
                            }
                        });
                        EventListener.queue.oninvisible.push(function() {
                            if (_me._hasBeenVisible && ((window.pageYOffset + window.innerHeight) < _me._el.offsetTop || window.pageYOffset > (_me._el.offsetTop + _me._el.scrollHeight))) {
                                _me._hasBeenInvisible = true;
                                _me._hasBeenVisible   = false;
                                _me._at = false;
                            }
                        });
                    },
                    oninvisible: function() {
                        EventListener.queue.oninvisible.push(function() {
                            if (!_me._at && _me._hasBeenVisible && ((window.pageYOffset + window.innerHeight) < _me._el.offsetTop || window.pageYOffset > (_me._el.offsetTop + _me._el.scrollHeight))) {
                                _me._cb.call();
                                _me._at = true;
                                _me._hasBeenInvisible = true;
                            }
                        });
                        EventListener.queue.onvisible.push(function() {
                            if (_me._hasBeenInvisible && (window.pageYOffset + window.innerHeight) > _me._el.offsetTop && window.pageYOffset < (_me._el.offsetTop + _me._el.scrollHeight)) {
                                _me._hasBeenVisible = true;
                                _me._hasBeenInvisible = false;
                                _me._at = false;
                            }
                        });
                    }
                };
            }
            EventListener.queue = {
                onvisible:   [],
                oninvisible: []
            };
            
            function addListener(element, event, fn) {
                element = document.getElementById(element);
                
                var listener = new EventListener(element, fn);
                
                if (listener['on' + event.toLowerCase()])
                return listener['on' + event.toLowerCase()].call();
            }
            
            window.onload = function() {
                
                try {
                    addListener('goldborder1', 'visible', function() {
                    document.getElementById("topgoldborder1").style.width = "calc((100%) + 30px)";
                    document.getElementById("bottomgoldborder1").style.width = "calc((100%) + 30px)";
                    document.getElementById("leftgoldborder1").style.height = "calc((100%) + 30px)";
                    document.getElementById("rightgoldborder1").style.height = "calc((100%) + 30px)";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    try {
                    addListener('goldborder2', 'visible', function() {
                    document.getElementById("topgoldborder2").style.width = "calc((100%) + 30px)";
                    document.getElementById("bottomgoldborder2").style.width = "calc((100%) + 30px)";
                    document.getElementById("leftgoldborder2").style.height = "calc((100%) + 30px)";
                    document.getElementById("rightgoldborder2").style.height = "calc((100%) + 30px)";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    try {
                    addListener('goldborder3', 'visible', function() {
                    document.getElementById("topgoldborder3").style.width = "calc((100%) + 30px)";
                    document.getElementById("bottomgoldborder3").style.width = "calc((100%) + 30px)";
                    document.getElementById("leftgoldborder3").style.height = "calc((100%) + 30px)";
                    document.getElementById("rightgoldborder3").style.height = "calc((100%) + 30px)";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('goldborder1', 'invisible', function() {
                    document.getElementById("topgoldborder1").style.width = "0";
                    document.getElementById("bottomgoldborder1").style.width = "0";
                    document.getElementById("leftgoldborder1").style.height = "0";
                    document.getElementById("rightgoldborder1").style.height = "0";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('goldborder2', 'invisible', function() {
                    document.getElementById("topgoldborder2").style.width = "0";
                    document.getElementById("bottomgoldborder2").style.width = "0";
                    document.getElementById("leftgoldborder2").style.height = "0";
                    document.getElementById("rightgoldborder2").style.height = "0";
                    });
                    } catch (error) {
                    console.error(error);
                    }
                    
                    
                    
                    try {
                    addListener('goldborder3', 'invisible', function() {
                    document.getElementById("topgoldborder3").style.width = "0";
                    document.getElementById("bottomgoldborder3").style.width = "0";
                    document.getElementById("leftgoldborder3").style.height = "0";
                    document.getElementById("rightgoldborder3").style.height = "0";
                    });
                    } catch (error) {
                    onsole.error(error);
                }
                
                //width anims for dividers
                
                try {
                    addListener('divider1', 'visible', function() {
                        document.getElementById("divider1").style.width = "60%";
                    });
                    } catch (error) {
                    console.error(error);
                }
                
                
                try {
                    addListener('divider1', 'invisible', function() {
                        document.getElementById("divider1").style.width = "0";
                    });
                    } catch (error) {
                    console.error(error);
                }
                
                
                /* try {
                    addListener('divider2', 'visible', function() {
                    document.getElementById("divider2").style.width = "60%";
                    });
                    } catch (error) {
                console.error(error);
                }
                
                
                
                try {
                addListener('divider2', 'invisible', function() {
                document.getElementById("divider2").style.width = "0";
                });
                } catch (error) {
                console.error(error);
                }
                */
                }
                
                
                </script>
                <?php
                }
                }
                add_action('wp_head', 'wpcom_javascript');
                                
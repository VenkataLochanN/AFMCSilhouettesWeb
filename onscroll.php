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
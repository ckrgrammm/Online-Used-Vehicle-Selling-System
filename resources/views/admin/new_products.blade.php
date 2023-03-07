
<!DOCTYPE html>

<style>
/*
=====
DEPENDENCES
=====
*/

/* 
helper to reset default browser's styles from headings
*/

.r-title{
    margin-top: var(--rTitleMarginTop, 0) !important;
    margin-bottom: var(--rTitleMarginBottom, 0) !important;
}

/* 
helper to hide elements that are available only for screen readers. 
*/

.screen-reader{
  width: var(--screenReaderWidth, 1px) !important;
  height: var(--screenReaderHeight, 1px) !important;
  padding: var(--screenReaderPadding, 0) !important;
  border: var(--screenReaderBorder, none) !important;

  position: var(--screenReaderPosition, absolute) !important;
  clip: var(--screenReaderClip, rect(1px, 1px, 1px, 1px)) !important;
  overflow: var(--screenReaderOverflow, hidden) !important;
}

/*
=====
POPUP
=====
*/

/*
1. Creating the top and bottom gaps for the modal so that content doesn't touches window's edges
*/

.popup:not(:target){
  display: none;
}

.popup:target{
  width: 100%;
  height: 100vh;
  
  display: flex;
 
  position: fixed;
  top: 0;
  right: 0;  
}

.popup::before{
  content: "";
  box-sizing: border-box;
  width: 100%;
  background-color: #fff;

  position: fixed;
  left: 0;
  top: 50%;
}

.popup::after{
  content: "";
  width: 0;
  height: 2px;
  background-color: #f0f0f0;

  position: absolute;
  top: 50%;
  left: 0;
  margin-top: -1px;
}

.popup__container{
  box-sizing: border-box;  
  padding: 5% 15%;

  height: calc(100vh - 40px); /* 1 */
  margin: auto; /* 1 */
  overflow: auto; /* 1 */
  overscroll-behavior: contain; /* 1 */
}

.popup__title{
  --rTitleMarginBottom: 1.5rem;
  font-size: 1.5rem;
}

.popup__close{
  width: 2rem;
  height: 2rem;

  position: fixed;
  top: 1.5rem;
  right: 1.5rem;

  background-repeat: no-repeat;
  background-position: center center;
  background-size: contain;
  background-image: url(data:image/svg+xml;base64,PHN2ZyBmaWxsPSIjMDAwMDAwIiBoZWlnaHQ9IjI0IiB2aWV3Qm94PSIwIDAgMjQgMjQiIHdpZHRoPSIyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4gICAgPHBhdGggZD0iTTE5IDYuNDFMMTcuNTkgNSAxMiAxMC41OSA2LjQxIDUgNSA2LjQxIDEwLjU5IDEyIDUgMTcuNTkgNi40MSAxOSAxMiAxMy40MSAxNy41OSAxOSAxOSAxNy41OSAxMy40MSAxMnoiLz4gICAgPHBhdGggZD0iTTAgMGgyNHYyNEgweiIgZmlsbD0ibm9uZSIvPjwvc3ZnPg==);
}

/*
animation
*/

.popup::before{
  will-change: height, top;
  animation: open-animation .6s cubic-bezier(0.83, 0.04, 0, 1.16) .65s both;
}

.popup::after{
  will-change: width, opacity;
  animation: line-animation .6s cubic-bezier(0.83, 0.04, 0, 1.16) both;
}

@keyframes line-animation{

  0%{
    width: 0;
    opacity: 1;
  }

  99%{
    width: 100%;
    opacity: 1;
  }

  100%{
    width: 100%;
    opacity: 0;
  }  
}

@keyframes open-animation{

  0%{
    height: 0;
    top: 50%;
  }

  100%{
    height: 100vh;
    top: 0;
  }
}

.popup__container{
  animation: fade .5s ease-out 1.3s both;
}

@keyframes fade{

  0%{
    opacity: 0;
  }

  100%{
    opacity: 1;
  }
}

/*
=====
DEMO
=====
*/

body{
  font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Open Sans, Ubuntu, Fira Sans, Helvetica Neue, sans-serif;
  font-size: 1rem;
  color: #222;
  background-color: #512da8;
  margin: 0;
}

p{
  margin: 0;
  line-height: 1.5;
}

p:nth-child(n+2){
  margin-top: 1rem;
}

.open-popup{
  color: #fff;
  text-decoration: none;
  text-transform: uppercase;
  padding: .75rem 1.25rem;
  border: 1px solid;
}

.page{
  min-height: 100vh;
  display: flex;
}

.page__container{
  max-width: 1200px;
  padding-left: .75rem;
  padding-right: .75rem;  
  margin: auto;
}
 
</style>


<!--
!!!!!!!!!
This demo is created to demonstrate animation of opening modal. Use it for inspiration  only. I use the a element to toggle the state of demo without JS. So DON"T USE it in production. If you want to use this animation you have to replace the element on the <button type="button">.
!!!!!!!!!
-->

<div class="page">
    <div class="page__container">
      <a href="#popup-article" class="open-popup">New Products</a>
    </div>
  </div>
  <div id="popup-article" class="popup">
    <div class="popup__container">
      <a href="#" class="popup__close">
        <span class="screen-reader">close</span>
      </a>  
      <div class="popup__content">
        <h1 class="popup__title r-title">Creating New Products</h1>
        <div class="row">  
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h1 class="card-description"> <strong>Warning</strong> This pages is for adding products purpose only !</h1>
                  <br>
                  <form class="forms-sample">
                    <div class="form-group">
                      <label for="exampleInputName1">Products Name</label>
                      <input type="text" class="form-control" id="exampleInputName1" placeholder="Name">
                    </div>
                    <div class="form-group">
                      <label for="exampleTextarea1">Products Description</label>
                      <textarea class="form-control" id="exampleTextarea1" rows="4" placeholder="Powered by a Passion. Refined in its technology and power. "></textarea>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword4">Price</label>
                      <input type="password" class="form-control" id="exampleInputPassword4" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <label for="exampleSelectGender">Stock</label>
                      <select class="form-control" id="exampleSelectGender">
                        <option>Male</option>
                        <option>Female</option>
                      </select>
                    </div>
                     <div class="form-group">
                      <label for="exampleInputPassword4">Category</label>
                      <input type="password" class="form-control" id="exampleInputPassword4" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <label>File upload</label>
                      <input type="file" name="img[]" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-gradient-primary" type="button">Upload</button>
                        </span>
                      </div>
                    </div>
                    
                   
                    <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
      </div>
    </div>
  </div>
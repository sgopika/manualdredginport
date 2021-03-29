

<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="vesseltab" data-toggle="tab" href="#tab1" role="tab" aria-controls="Vessel Details" aria-selected="true">Vessel Details</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="hulltab" data-toggle="tab" href="#tab2" role="tab" aria-controls="Hull" aria-selected="false">Hull Details</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="enginetab" data-toggle="tab" href="#tab3" role="tab" aria-controls="Engine" aria-selected="false">Engine Details</a>
  </li>
</ul>
<div class="tab-content " id="myTabContent">
  <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="vesseltab">
    <!-- start of content in tab pane -->
   
  </div><!-- end of tab-pane 1 -->
  <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="hulltab">
   <!-- start of content in tab pane -->

If you’re using navs to provide a navigation bar, be sure to add a role="navigation" to the most logical parent container of the <ul>, or wrap a <nav> element around the whole navigation. Do not add the role to the <ul> itself, as this would prevent it from being announced as an actual list by assistive technologies.

    <!-- end of content in tab pane -->
  </div><!-- end of tab-pane 2 -->
  <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="enginetab">
   <!-- start of content in tab pane -->

Note that dynamic tabbed interfaces should not contain dropdown menus, as this causes both usability and accessibility issues. From a usability perspective, the fact that the currently displayed tab’s trigger element is not immediately visible (as it’s inside the closed dropdown menu) can cause confusion. From an accessibility point of view, there is currently no sensible way to map this sort of construct to a standard WAI ARIA pattern, meaning that it cannot be easily made understandable to users of assistive technologies.

    <!-- end of content in tab pane -->
  </div><!-- end of tab-pane 3 -->
</div> <!-- end of tab -content -->




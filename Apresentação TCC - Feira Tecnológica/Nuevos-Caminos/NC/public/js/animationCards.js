document.addEventListener("DOMContentLoaded", function () {
  const links = document.querySelectorAll('a[href^="#"]');
  links.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      const targetId = this.getAttribute("href").substring(1);
      const targetElement = document.getElementById(targetId);
      if (targetElement) {
        gsap.to(window, {
          duration: 1.2, // Aumenta a duração da animação para 1.2 segundos
          scrollTo: {
            y: targetElement.offsetTop - 60, // Adiciona um deslocamento para não cobrir o conteúdo
            autoKill: true,
          },
          ease: "power2.inOut",
        });
      }
    });
  });

  const sidebar = document.getElementById("scroll-trigger");
  const navbar = document.querySelector(".navbar");
  const footer = document.querySelector("footer");

  let sidebarInitialTop =
    sidebar.getBoundingClientRect().top + window.pageYOffset;
  const navbarHeight = navbar ? navbar.offsetHeight : 0;
  const additionalOffset = 60;

  function updateSidebar() {
    const scrollY = window.pageYOffset;
    const viewportHeight = window.innerHeight;
    const footerTop = footer.getBoundingClientRect().top + window.pageYOffset;
    const sidebarHeight = sidebar.offsetHeight;

    if (scrollY >= sidebarInitialTop - navbarHeight - additionalOffset) {
      sidebar.style.position = "fixed";
      sidebar.style.top = navbarHeight + additionalOffset + "px";
      sidebar.style.maxHeight = `calc(100vh - ${
        navbarHeight + additionalOffset
      }px)`;
      sidebar.style.overflowY = "auto";

      if (
        scrollY + navbarHeight + additionalOffset + sidebarHeight >
        footerTop
      ) {
        const newTop = footerTop - sidebarHeight - scrollY;
        sidebar.style.top = newTop + "px";
      }
    } else {
      sidebar.style.position = "static";
      sidebar.style.top = "auto";
      sidebar.style.maxHeight = "none";
      sidebar.style.overflowY = "visible";
    }
  }

  window.addEventListener("scroll", updateSidebar);
  window.addEventListener("resize", function () {
    sidebarInitialTop =
      sidebar.getBoundingClientRect().top + window.pageYOffset;
    updateSidebar();
  });

  updateSidebar();
});

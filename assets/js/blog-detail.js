new Vue({
  el: "#app",
  components: {
    "navbar-component": httpVueLoader("./components/navbar.vue"),
    "interest-component": httpVueLoader("./components/interest.vue"),
    "star-component": httpVueLoader("./components/star.vue"),
    "footer-component": httpVueLoader("./components/footer.vue"),
  },
  data() {
    return {
      blogInterest: null,
      blog: null,
      auth: {
        token: TOKEN,
        data: AUTH_DATA,
      },
      message: null,
      thumbnails: [],
      comments: [],
    };
  },
  mounted() {
    this.getBlog();

    if (blogBranchName == "cessru") {
      this.interestCE();
    } else if (blogBranchName == "rbessru") {
      this.interestRBE();
    } else if (blogBranchName == "messru") {
      this.interestME();
    } else if (blogBranchName == "stohssru") {
      this.interestSTOH();
    } else if (blogBranchName == "ietssru") {
      this.interestIET();
    } else if (blogBranchName == "real-fmssru") {
      this.interestREALFM();
    } else if (blogBranchName == "gmdssru") {
      this.interestGMD();
    } else if (blogBranchName == "iedssru") {
      this.interestIED();
    } else if (blogBranchName == "idssru") {
      this.interestID();
    } else if (blogBranchName == "printingssru") {
      this.interestPRINTING();
    }

    if (window.location.href.includes("pic") || window.location.href.includes("video")) {
      this.ecommerceThumbnail();
    }
  },
  methods: {
    getId() {
      if (window.location.href.includes("pic")) {
        let regex = new RegExp("pic/[0-9]+"),
          results = regex.exec(window.location.href),
          id = results[0].split("/");
        return id[1];
      } else if (window.location.href.includes("3d")) {
        let regex = new RegExp("3d/[0-9]+"),
          results = regex.exec(window.location.href),
          id = results[0].split("/");
        return id[1];
      } else if (window.location.href.includes("video")) {
        let regex = new RegExp("video/[0-9]+"),
          results = regex.exec(window.location.href),
          id = results[0].split("/");
        return id[1];
      }
    },
    getBlog() {
      axios
        .get("/detail", {
          params: {
            id: this.getId(),
          },
        })
        .then((resp) => {
          this.blog = resp.data.response;
          this.comments = this.blog.comments;
        })
        .catch(() => location.assign("./"));
    },
    interestCE() {
      if (window.location.href.includes("3d")) {
        axios
          .get("/3d/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      } else if (window.location.href.includes("pic")) {
        axios
          .get("/pic/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      } else if (window.location.href.includes("video")) {
        axios
          .get("/video/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      }
    },
    interestRBE() {
      if (window.location.href.includes("3d") && blogBranchName == "rbessru") {
        axios
          .get("rbe/3d/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      } else if (window.location.href.includes("pic") && blogBranchName == "rbessru") {
        axios
          .get("rbe/pic/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      } else if (window.location.href.includes("video")) {
        axios
          .get("rbe/video/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      }
    },
    interestME() {
      if (window.location.href.includes("3d") && blogBranchName == "messru") {
        axios
          .get("me/3d/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      } else if (window.location.href.includes("pic") && blogBranchName == "messru") {
        axios
          .get("me/pic/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      } else if (window.location.href.includes("video")) {
        axios
          .get("me/video/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      }
    },
    interestSTOH() {
      if (window.location.href.includes("3d") && blogBranchName == "stohssru") {
        axios
          .get("stoh/3d/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      } else if (window.location.href.includes("pic") && blogBranchName == "stohssru") {
        axios
          .get("stoh/pic/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      } else if (window.location.href.includes("video")) {
        axios
          .get("stoh/video/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      }
    },
    interestIET() {
      if (window.location.href.includes("3d") && blogBranchName == "ietssru") {
        axios
          .get("iet/3d/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      } else if (window.location.href.includes("pic") && blogBranchName == "ietssru") {
        axios
          .get("iet/pic/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      } else if (window.location.href.includes("video")) {
        axios
          .get("iet/video/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      }
    },
    interestREALFM() {
      if (window.location.href.includes("3d") && blogBranchName == "real-fmssru") {
        axios
          .get("real-fm/3d/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      } else if (window.location.href.includes("pic") && blogBranchName == "real-fmssru") {
        axios
          .get("real-fm/pic/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      } else if (window.location.href.includes("video")) {
        axios
          .get("real-fm/video/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      }
    },
    interestGMD() {
      if (window.location.href.includes("3d") && blogBranchName == "gmdssru") {
        axios
          .get("gmd/3d/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      } else if (window.location.href.includes("pic") && blogBranchName == "gmdssru") {
        axios
          .get("gmd/pic/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      } else if (window.location.href.includes("video")) {
        axios
          .get("gmd/video/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      }
    },
    interestIED() {
      if (window.location.href.includes("3d") && blogBranchName == "iedssru") {
        axios
          .get("ied/3d/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      } else if (window.location.href.includes("pic") && blogBranchName == "iedssru") {
        axios
          .get("ied/pic/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      } else if (window.location.href.includes("video")) {
        axios
          .get("ied/video/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      }
    },
    interestID() {
      if (window.location.href.includes("3d") && blogBranchName == "idssru") {
        axios
          .get("id/3d/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      } else if (window.location.href.includes("pic") && blogBranchName == "idssru") {
        axios
          .get("id/pic/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      } else if (window.location.href.includes("video")) {
        axios
          .get("id/video/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      }
    },
    interestPRINTING() {
      if (window.location.href.includes("3d") && blogBranchName == "printingssru") {
        axios
          .get("printing/3d/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      } else if (window.location.href.includes("pic") && blogBranchName == "printingssru") {
        axios
          .get("printing/pic/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      } else if (window.location.href.includes("video")) {
        axios
          .get("printing/video/interest", {
            params: {
              current: this.getId(),
            },
          })
          .then((resp) => (this.blogInterest = resp.data.response))
          .catch(() => location.assign("./"));
      }
    },
    submitComment() {
      let comment = {
        comment_id: 2,
        u_id: this.auth.data.u_id,
        message: this.message,
        firstname: this.auth.data.firstname,
        lastname: this.auth.data.lastname,
        image: this.auth.data.image,
        created_at: new Date(),
        blog_id: this.getId(),
      };
      
      if (this.containBadWord(comment.message)) {
        Swal.fire({
          icon: "error",
          title: "ไม่สามารถแสดงความคิดเห็นได้",
          text: "มีคำหยาบภายในการแสดงความคิดเห็น!",
        });
        this.message = null;
        return;
      }

      this.comments.push(comment);
      this.message = null;

      axios({
        method: "post",
        url: "/comment/create",
        data: comment,
      }).then((result) => {
        location.reload();
      }).catch((error) => {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "การกรอกข้อมูลมีความผิดพลาด โปรดกรอกใหม่อีกครั้ง",
        }).then(() => {
          location.reload();
        });
      });
    },
    containBadWord(text) {
      const badWords = ["Shit" , "Fuck" , "Damn" , "darn" , "Bitch" , "Crap" , "Piss" , "Dick" ,
                          "Cock" , "Pussy" , "Bastard" , "Shitbag" , "Bollocks" , "Knob Head" , 
                          "Cunt" , "Arsehole" , "Asshole" , "Bugger" , "Bloody hell" , "Wanker" , 
                          "Moron" , "Jerk" , "Stupid" , "Fool" , "Retarded" , "Noob" , "Loser" , 
                          "Screw you" , "Coward" , "Jackass", "What the fuck" , "What the hell" , 
                          "What the heck" , "Dumbass", "อี", "ไอ", "กู", "มึง", "ดอก","เหี้ย", "ห่า", "ควย", "หมา",
                          "ชาติชั่ว", "สัส", "สัตว", "ควาย", "ตอแหล", "เฮงซวย", "ต่ำๆ", "โง", "กาก", "หน้าด้าน", "เปรต", "ถ่อย",
                          "บ้า", "ระยำ", "จังไร", "สัมภเวสี", "งูพิษ", "พ่อง", "แม่ง", "เย็ด", "สาด", "นรก", "ไก่อ่อน", "วรนุช"];

      const lowercaseText = text.toLowerCase();

      for(const badWord of badWords) {
        if (lowercaseText.includes(badWord.toLocaleLowerCase())) {
          return true;
        }
      }
      return false;
    },
    deleteComment(commentId) {
      let comment = {comment_id: commentId};
      Swal.fire({
        title: 'คุณต้องการลบความคิดเห็น ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่',
        cancelButtonText: 'ไม่ใช่'
      }).then((result) => {
        if (result.isConfirmed) {
          axios({
            method: "delete",
            url: "/comment/delete",
            data: { comment_id: commentId },
          }).then((result) => {
            Swal.fire({
              title: 'ลบความคิดเห็นเรียบร้อยแล้ว',
              icon: 'success',
              timer: '1500',
              showConfirmButton: false,
              allowOutsideClick: false,
              allowEscapeKey: false
            }).then((result) => {
              location.reload();
            })
          }).catch((error) => {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "มีความผิดพลาด โปรดลองใหม่อีกครั้ง",
            }).then(() => {
              location.reload();
            });
          })
        }
      })
    },
    ecommerceThumbnail() {
      window.onload = function () {
        if (window.location.href.includes("pic")) {
          const thumbnails = document.getElementsByClassName("thumbnail");
          const activeImages = document.getElementsByClassName("thumbnail active");     
          const showFull = document.getElementById("showFull");
          const featuredMain = document.getElementById("featured");
          const featuredFull = document.getElementById("featuredFull");
          const closeFull = document.getElementById("close-full");     
          const buttonRight = document.getElementById("buttonRight");
          const buttonLeft = document.getElementById("buttonLeft");
          const slider = document.getElementById("slider");

          for (var i = 0; i < thumbnails.length; i++) {
            thumbnails[i].addEventListener("click", function () {
              if (activeImages.length > 0) {
                activeImages[0].classList.remove("active");
              }

              this.classList.add("active");
              document.getElementById("featured").src = this.src;
            });
            if (thumbnails[i].src == featuredMain.src){
              thumbnails[i].classList.add("active");
            }
          }

          if (thumbnails.length > 4) {
            buttonRight.style.display = "block";
            buttonLeft.style.display = "block";
          }

          if (thumbnails.src == featuredMain.src) {
            console.log(thumbnails.src)
            console.log(featuredMain.src)
          }

          buttonLeft.addEventListener("click", function () {
            slider.scroll({
              left: slider.scrollLeft - 360,
              behavior: "smooth",
            });
          });

          buttonRight.addEventListener("click", function () {
            slider.scroll({
              left: slider.scrollLeft + 360,
              behavior: "smooth",
            });
          });

          featuredMain.addEventListener("click", function () {
            showFull.style.display = "flex";
            featuredFull.src = this.src;
          });

          closeFull.addEventListener("click", function () {
            showFull.style.display = "none";
          });
        }
      };
    }
  },
  beforeUpdate() {
    this.$nextTick(function () {
      /** call tooltips bootstrap5 */
      let tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
      );
      tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
      /** call sharethis */
      var script = document.createElement("script");
      script.src =
        "https://platform-api.sharethis.com/js/sharethis.js#property=5fa59bebea34a200144b93aa&product=inline-reaction-buttons";
      document.getElementsByTagName("head")[0].appendChild(script);
    });
  },
});

// const urlParams = new URLSearchParams(window.location.search);
// const myParam = urlParams.get('myParam');

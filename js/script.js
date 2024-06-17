function changeLanguage(lang) {
    // Get all elements with the data-i18n attribute
    var elements = document.querySelectorAll('[data-i18n]');
    
    // Loop through each element
    elements.forEach(function(element) {
        // Get the translation key
        var key = element.getAttribute('data-i18n');
        
        // Depending on the selected language, set the innerHTML of the element accordingly
        switch (lang) {
            case 'en':
                element.innerHTML = translations.en[key];
                break;
            case 'fr':
                element.innerHTML = translations.fr[key];
                break;
            case 'ar':
                element.innerHTML = translations.ar[key];
                break;
            default:
                // If the selected language is not supported, default to English
                element.innerHTML = translations.en[key];
        }
    });
  
    // Load CSS file for Arabic language
    if (lang === 'ar') {
        loadCss('css/index_ar.css');
    } else {
        // Remove the Arabic CSS file if it was loaded before
        var arabicCss = document.getElementById('arabic-css');
        if (arabicCss) {
            arabicCss.parentNode.removeChild(arabicCss);
        }
    }
  }
  
  function loadCss(filename) {
    var link = document.createElement('link');
    link.id = 'arabic-css';
    link.rel = 'stylesheet';
    link.href = filename;
    document.head.appendChild(link);
  }
  
  
  
  
  var translations = {
      en: {
        home: "Home",
        veterinarian: "Veterinarian",
        faq: "FAQ",
        contact: "Contact us",
        language: "language",
        en: "English",
        fr: "French",
        ar: "Arabic",
        sign: "SIGN IN",
        welcom:"Welcome, To FarmVet World",
        welcom_txt:"Find the right veterinary now, for optimal livestock health and agricultural productivity.",
        Empowering:"Empowering Farmers and Veterinarians to safeguard Farm Animal Health",
        Empowering_p:"Our feature section highlights the critical role of monitoring and controllinginfectious diseases in farm animals. By linking farmers and veterinarians, weenable them to collaborate on disease prevention, health care, vaccinations, and animal nutrition.",
        Monitoring:"Monitoring and Controlling Infectious Diseases",
        Health:"Health Care for Farm Animals",
        Expert:"Expert Advice on Animal Nutrition",
        rthm:"Real-time Health Monitoring",
        provides:"Farmvet provides real-time health monitoring for your animals, allowing you totrack their well-being and detect any potential issues early on. Stay informedand take proactive measures to ensure the health and safety of your livestock",
        disease:"Disease Control",
        diseases_p:"With Farmvet, you have the power to control diseases on your farm. Ourplatform helps you identify and manage diseases, providing you with thenecessary tools and resources to prevent outbreaks and minimize the impact onyour animals.",
        rapid_vet:"Rapid Veterinary Intervention",
        rapid_vet_p:"In case of emergencies, Farmvet enables you to quickly connect with veterinaryprofessionals. Our platform facilitates rapid intervention, ensuring that youranimals receive timely and appropriate medical care when they need it the most.",
        nrm:"Nutrition and\n Reproductive\n Management Solutions",
        nrm_p:"Our team of experts provides valuable advice and solutions for animal nutrition and reproductive management. From optimizing diets to enhancing breeding programs, we help farmers maximize the health and productivity of their animals",
        learn:"Learn More",
        signup:"Sign Up",
        connecting:"Connecting with veterinarians made easy through the Farmvet platform",
        connecting_p:"With Farmvet, you can easily connect with veterinarians to monitor animal health and control diseases.",
        percent1:"Monitor animal health, control diseases, and get expert advice.",
        percent2:"Benefit from the intervention of a highly qualified veterinarian as soon as possible",
        connect:"Connecting",
        expert:"Our Experts",
        expert_p:"Meet our team of expert veterinarians and support staff",
        read:"Read More",
        view:"View More",
        join:"Join US",
        fm_p:"learn how Farmvet works and the Benefits it provides for farmers and veterinarians",
        Q1:"How does Farmvet work?",
        answr1:"Farmvet acts as a point of contact between farmers and veterinarians, allowing them to monitor the health of animals, combat diseases, and intervene quickly, and helps them stay informed of the latest epidemics, medicines, and news in the field. In addition, it connects veterinarians with suppliers and pharmaceutical companies.",
        Q2:"What are the benefits of Farmvet?",
        answr2:"Farmvet provides farmers with easy access to veterinary services, helping them keep their animals healthy and prevent the spread of diseases. It alsoprovides a convenient online store for veterinarians that enables them to purchase all essential medications and tools to help them perform their work",
        Q3:"How can I contact Farmvet?",
        answr3:" For any queries or assistance, you can contact our Farmvet support team through Our contact page.",
        Q4:"Can I get veterinary advice?",
        answr4:"Yes. Farmvet provides farmers with access to veterinary advice and guidance to ensure the health of their animals",
        Q5:"How can I buy medicines?",
        answr5:"Farmvet offers an easy-to-use online store for veterinarians where they can browse and purchase the medications needed to do their work",
        for_vet:"For veterinarian",
        discover_store:"Discover the essential tools you need in our store",
        store_p:"Browse our wide range of emergency kits designed to help you deal with any animal illness. From first aid kits to power generators, we have everything you need to ensure the quality  of your services and the satisfaction of your customers.",
        syringes:"Syringes & needles",
        supp_n:"Suppilier name",
        Shop:"Shop now",
        have_q:"Have a question or need support? Get in touch with us.",
        email:"Email",
        email_p:"Send us an email",
        phone:"Phone",
        phone_p:"Call us for assistance",
        office:"Office",
        office_p:"Sidi bel Abbes, Sidi Bel abbes.",
        direction:"Get Direction",
        forgot:"Forgot password",
      },
      fr:{
        home: "Accueil",
        veterinarian: "Vétérinaire",
        faq: "FAQ",
        contact: "Contactez-nous",
        language:'langue',
        en: "Anglais",
        fr: "Français",
        ar: "arabe",
        sign: "SE CONNECTER",
        welcom:"Bienvenue dans le monde FarmVet",
        welcom_txt:"Trouvez le bon vétérinaire dès maintenant, pour une santé du bétail et une productivité agricole optimales.",
        Empowering:"Donner aux agriculteurs et aux vétérinaires les moyens de préserver la santé des animaux d’élevage.",
        Empowering_p:"Notre section thématique met en évidence le rôle essentiel de la surveillance et du contrôle des maladies infectieuses chez les animaux de ferme. En reliant les agriculteurs et les vétérinaires, nous leur permettons de collaborer en matière de prévention des maladies, de soins de santé, de vaccinations et de nutrition animale.",
        Monitoring:"Surveillance et contrôle des maladies infectieuses",
        Health:"Soins de santé pour les animaux de ferme",
        Expert:"Conseils d'experts sur la nutrition animale",
        rthm:"Surveillance de la santé en temps réel",
        provides:"Farmvet fournit une surveillance de la santé de vos animaux en temps réel, vous permettant de suivre leur bien-être et de détecter rapidement tout problème potentiel. Restez informé et prenez des mesures proactives pour assurer la santé et la sécurité de votre bétail",
        disease:"Contrôle de maladie",
        diseases_p:"Avec Farmvet, vous avez le pouvoir de contrôler les maladies dans votre ferme. Notre plateforme vous aide à identifier et à gérer les maladies, en vous fournissant les outils et les ressources nécessaires pour prévenir les épidémies et minimiser l'impact sur vos animaux.",
        rapid_vet:"Intervention vétérinaire rapide",
        rapid_vet_p:"En cas d'urgence, Farmvet vous permet de vous connecter rapidement avec des professionnels vétérinaires. Notre plateforme facilite une intervention rapide, garantissant que vos animaux reçoivent des soins médicaux appropriés et en temps opportun lorsqu'ils en ont le plus besoin.",
        nrm:"Solutions de nutrition et\n de gestion de la reproduction\n",
        nrm_p:"Notre équipe d’experts fournit de précieux conseils et solutions en matière de nutrition animale et de gestion de la reproduction. De l'optimisation des régimes alimentaires à l'amélioration des programmes d'élevage, nous aidons les agriculteurs à maximiser la santé et la productivité de leurs animaux.",
        learn:"apprendre plus",
        signup:"S'inscrire",
        connecting:"La connexion avec les vétérinaires est facilitée grâce à la plateforme Farmvet",
        connecting_p:"Avec Farmvet, vous pouvez facilement vous connecter avec des vétérinaires pour surveiller la santé des animaux et contrôler les maladies.",
        percent1:"Surveillez la santé animale, contrôlez les maladies et obtenez des conseils d’experts.",
        percent2:"Bénéficiez de l’intervention d’un vétérinaire hautement qualifié dans les plus brefs délais",
        connect:"Connexion",
        expert:"Nos Experts",
        expert_p:"Rencontrez notre équipe de vétérinaires experts et de personnel de soutien",
        read:"En savoir plus",
        view:"Voir plus",
        join:"Rejoignez-nous",
        fm_p:"découvrez comment Farmvet fonctionne et les avantages qu'il offre aux agriculteurs et aux vétérinaires",
        Q1:"Comment fonctionne Farmvet ?",
        answr1:"Farmvet agit comme point de contact entre les éleveurs et les vétérinaires, leur permettant de surveiller la santé des animaux, de lutter contre les maladies et d'intervenir rapidement, et les aide à rester informés des dernières épidémies, médicaments et actualités du domaine. De plus, il met en relation les vétérinaires avec les fournisseurs et les sociétés pharmaceutiques.",
        Q2:"Quels sont les avantages de Farmvet ?",
        answr2:"Farmvet offre aux agriculteurs un accès facile aux services vétérinaires, les aidant à garder leurs animaux en bonne santé et à prévenir la propagation des maladies. Il fournit également une boutique en ligne pratique pour les vétérinaires qui leur permet d'acheter tous les médicaments et outils essentiels pour les aider à effectuer leur travail.",
        Q3:"Comment puis-je contacter Farmvet ?",
        answr3:" Pour toute question ou assistance, vous pouvez contacter notre équipe d'assistance Farmvet via notre page de contact.",
        Q4:"Puis-je obtenir des conseils vétérinaires ?",
        answr4:"Oui. Farmvet offre aux agriculteurs un accès à des conseils et des orientations vétérinaires pour garantir la santé de leurs animaux.",
        Q5:"Comment puis-je acheter des médicaments ?",
        answr5:"Farmvet offers an easy-to-use online store for veterinarians where they can browse and purchase the medications needed to do their work",
        for_vet:"Pour vétérinaire",
        discover_store:"Découvrez les outils indispensables dont vous avez besoin dans notre magasin",
        store_p:"Parcourez notre large gamme de kits d'urgence conçus pour vous aider à faire face à toute maladie animale. Des trousses de premiers secours aux groupes électrogènes, nous avons tout ce dont vous avez besoin pour assurer la qualité de vos services et la satisfaction de vos clients.",
        syringes:"Seringues et aiguilles",
        supp_n:"Nom du fournisseur",
        Shop:"Achetez maintenant",
        have_q:"Vous avez une question ou besoin d'aide ? Prenez contact avec nous.",
        email:"E-mail",
        email_p:"Envoyez-nous un e-mail",
        phone:"Téléphone",
        phone_p:"Appelez-nous pour obtenir de l'aide",
        office:"Bureau",
        office_p:"Sidi bel Abbes, Sidi Bel abbes.",
        direction:"Obtenir une direction",
        forgot:"mot de pass oublié",
    
      },
      ar: {
        home:  "الصفحة الرئيسية",
        veterinarian: "البيطريين",
        faq: "التعليمات",
        contact: "تواصل معنا",
        language:'اللغة',
        en: "انجليزية",  
        fr: "فرنسية",
        ar: "عربية",
        sign: "تسجيل دخول",
        welcom:"مرحبًا بكم في عالم FarmVet",
        welcom_txt:"ابحث عن الطبيب البيطري المناسب الآن، للحصول على صحة مثالية للماشية وإنتاجية زراعية.",
        Empowering:"تمكين المزارعين والأطباء البيطريين لحماية صحة حيوانات المزرعة",
        Empowering_p:"يسلط قسم الميزات لدينا الضوء على الدور الحاسم لرصد ومراقبة الأمراض المعدية في حيوانات المزرعة. ومن خلال الربط بين المزارعين والأطباء البيطريين، يمكننا تمكينهم من التعاون في الوقاية من الأمراض، والرعاية الصحية، والتطعيمات، وتغذية الحيوانات.",
        Monitoring:"مراقبة ومكافحة الأمراض المعدية",
        Health:"الرعاية الصحية لحيوانات المزرعة",
        Expert:"مشورة الخبراء بشأن تغذية الحيوان",
        rthm:"مراقبة الصحة في الوقت الحقيقي",
        provides:"يوفر Farmvet مراقبة صحية لحيواناتك في الوقت الفعلي، مما يسمح لك بتتبع صحتها واكتشاف أي مشكلات محتملة في وقت مبكر. ابق على اطلاع واتخذ تدابير استباقية لضمان صحة وسلامة ماشيتك",
        disease:"مكافحة الأمراض",
        diseases_p:"مع Farmvet، لديك القدرة على السيطرة على الأمراض في مزرعتك. تساعدك منصتنا على تحديد الأمراض وإدارتها، مما يوفر لك الأدوات والموارد اللازمة لمنع تفشي المرض وتقليل التأثير على حيواناتك.",
        rapid_vet:"التدخل البيطري السريع",
        rapid_vet_p:"في حالات الطوارئ، يمكّنك Farmvet من التواصل بسرعة مع المتخصصين في الطب البيطري. تسهل منصتنا التدخل السريع، مما يضمن حصول حيواناتك على الرعاية الطبية المناسبة وفي الوقت المناسب عندما تكون في أمس الحاجة إليها",
        nrm:"حلول التغذية\n وإدارة\n الإنجاب",
        nrm_p:"يقدم فريق الخبراء لدينا نصائح وحلول قيمة لتغذية الحيوانات وإدارة الإنجاب. بدءًا من تحسين الأنظمة الغذائية وحتى تعزيز برامج التربية، فإننا نساعد المزارعين على تحقيق أقصى قدر من الصحة والإنتاجية لحيواناتهم",
        learn:"تعلم أكثر",
        signup:"انضم إلينا",
        connecting:"أصبح التواصل مع الأطباء البيطريين أمرًا سهلاً من خلال منصة Farmvet",
        connecting_p:"مع Farmvet، يمكنك التواصل بسهولة مع الأطباء البيطريين لمراقبة صحة الحيوان ومكافحة الأمراض.",
        percent1:"مراقبة صحة الحيوان ومكافحة الأمراض والحصول على مشورة الخبراء.",
        percent2:"الاستفادة من تدخل طبيب بيطري مؤهل تأهيلا عاليا في أسرع وقت ممكن",
        connect:"تواصل",
        expert:"خبرائنا",
        expert_p:"تعرف على فريقنا من الأطباء البيطريين الخبراء وموظفي الدعم",
        read:"اقرأ المزيد",
        view:"عرض المزيد",
        join:"انضم إلينا",
        fm_p:"تعرف على كيفية عمل Farmvet والفوائد التي يقدمها للمزارعين والأطباء البيطريين",
        Q1:"كيف يعمل Farmvet؟",
        answr1:"يعمل Farmvet كنقطة اتصال بين المزارعين والأطباء البيطريين، مما يسمح لهم بمراقبة صحة الحيوانات ومكافحة الأمراض والتدخل السريع، ويساعدهم على البقاء على اطلاع بأحدث الأوبئة والأدوية والأخبار الميدانية. بالإضافة إلى ذلك، فهو يربط الأطباء البيطريين بالموردين وشركات الأدوية.",
        Q2:"ما هي فوائد Farmvet؟",
        answr2:"يوفر Farmvet للمزارعين سهولة الوصول إلى الخدمات البيطرية، مما يساعدهم على الحفاظ على صحة حيواناتهم ومنع انتشار الأمراض. كما يوفر متجرًا إلكترونيًا مناسبًا للأطباء البيطريين يمكّنهم من شراء جميع الأدوية والأدوات الأساسية التي تساعدهم في أداء عملهم",
        Q3:"كيف يمكنني التواصل مع Farmvet؟",
        answr3:"لأية استفسارات أو مساعدة، يمكنك الاتصال بفريق دعم Farmvet من خلال صفحة الاتصال الخاصة بنا.",
        Q4:"هل يمكنني الحصول على المشورة البيطرية؟",
        answr4:"نعم. يوفر Farmvet للمزارعين إمكانية الوصول إلى النصائح والإرشادات البيطرية لضمان صحة حيواناتهم",
        Q5:"كيف يمكنني شراء الأدوية؟",
        answr5:"يقدم Farmvet متجرًا إلكترونيًا سهل الاستخدام للأطباء البيطريين حيث يمكنهم تصفح وشراء الأدوية اللازمة للقيام بعملهم",
        for_vet:"البيطريين فقط",
        discover_store:"اكتشف الأدوات الأساسية\ التي تحتاجها في متجرنا",
        store_p:"تصفح مجموعتنا الواسعة من أدوات الطوارئ المصممة لمساعدتك في التعامل مع أي مرض يصيب الحيوان. بدءًا من مجموعات الإسعافات الأولية وحتى مولدات الطاقة، لدينا كل ما تحتاجه لضمان جودة خدماتك ونيل رضا عملائك.",
        syringes:"المحاقن والإبر",
        supp_n:"اسم المورد",
        Shop:"تسوق الآن",
        have_q:"هل لديك سؤال أو بحاجة إلى الدعم؟ ابق على تواصل معنا.",
        email:"البريد الإلكتروني",
        email_p:"مراسلتنا على البريد الاليكتروني",
        phone:"هاتف",
        phone_p:"اتصل بنا للحصول على المساعدة",
        office:"مكتب",
        office_p:"سيدي بلعباس، سيدي بلعباس.",
        direction:"احصل على اتجاه",
        forgot:"نسيت كلمة السر",
        addCssToBody: true,
    },
};

  <div class="hero-profile-bg">
    <svg class="profile-svg" viewBox="0 0 520 480" fill="none" xmlns="http://www.w3.org/2000/svg">
      <defs>
        <linearGradient id="alum" x1="0" y1="0" x2="1" y2="1">
          <stop offset="0%" stop-color="rgba(180,195,230,0.35)"/>
          <stop offset="50%" stop-color="rgba(140,165,210,0.25)"/>
          <stop offset="100%" stop-color="rgba(100,130,200,0.35)"/>
        </linearGradient>
        <linearGradient id="alumEdge" x1="0" y1="0" x2="0" y2="1">
          <stop offset="0%" stop-color="rgba(200,215,255,0.5)"/>
          <stop offset="100%" stop-color="rgba(120,145,200,0.25)"/>
        </linearGradient>
        <linearGradient id="thermal" x1="0" y1="0" x2="1" y2="0">
          <stop offset="0%" stop-color="rgba(25,62,234,0.4)"/>
          <stop offset="50%" stop-color="rgba(60,100,255,0.25)"/>
          <stop offset="100%" stop-color="rgba(25,62,234,0.4)"/>
        </linearGradient>
        <linearGradient id="glass" x1="0" y1="0" x2="0" y2="1">
          <stop offset="0%" stop-color="rgba(140,200,255,0.3)"/>
          <stop offset="50%" stop-color="rgba(100,170,255,0.15)"/>
          <stop offset="100%" stop-color="rgba(140,200,255,0.3)"/>
        </linearGradient>
        <linearGradient id="chamberGlow" x1="0" y1="0" x2="0" y2="1">
          <stop offset="0%" stop-color="rgba(25,62,234,0.15)"/>
          <stop offset="100%" stop-color="rgba(25,62,234,0.04)"/>
        </linearGradient>
        <filter id="glow"><feGaussianBlur stdDeviation="3" result="blur"/><feMerge><feMergeNode in="blur"/><feMergeNode in="SourceGraphic"/></feMerge></filter>
        <filter id="softGlow"><feGaussianBlur stdDeviation="6" result="blur"/><feMerge><feMergeNode in="blur"/><feMergeNode in="SourceGraphic"/></feMerge></filter>
      </defs>

      <!-- ========== LEFT SASH (СТВОРКА) ========== -->
      <g class="profile-left">
        <!-- Outer frame -->
        <path d="M30 20 h180 v440 h-180 Z" fill="url(#alum)" stroke="url(#alumEdge)" stroke-width="1.2"/>
        <!-- Outer lip top -->
        <path d="M20 15 h10 v450 h-10 Z" fill="rgba(180,200,240,0.2)" stroke="rgba(200,220,255,0.35)" stroke-width="0.8"/>
        <!-- Outer decorative groove -->
        <path d="M25 30 v420" stroke="rgba(255,255,255,0.14)" stroke-width="0.5"/>

        <!-- CHAMBER 1 - top left -->
        <rect class="chamber c1" x="42" y="32" width="55" height="70" rx="2" fill="url(#chamberGlow)" stroke="rgba(180,200,255,0.28)" stroke-width="0.8"/>
        <!-- CHAMBER 2 - top middle -->
        <rect class="chamber c2" x="105" y="32" width="42" height="70" rx="2" fill="url(#chamberGlow)" stroke="rgba(180,200,255,0.28)" stroke-width="0.8"/>
        <!-- CHAMBER 3 - top right -->
        <rect class="chamber c3" x="155" y="32" width="44" height="70" rx="2" fill="url(#chamberGlow)" stroke="rgba(180,200,255,0.28)" stroke-width="0.8"/>

        <!-- Rib separators -->
        <line x1="42" y1="110" x2="199" y2="110" stroke="rgba(200,220,255,0.28)" stroke-width="1.2"/>
        
        <!-- CHAMBER 4 - middle wide -->
        <rect class="chamber c4" x="42" y="118" width="80" height="55" rx="2" fill="url(#chamberGlow)" stroke="rgba(180,200,255,0.28)" stroke-width="0.8"/>
        <!-- CHAMBER 5 -->
        <rect class="chamber c5" x="130" y="118" width="69" height="55" rx="2" fill="url(#chamberGlow)" stroke="rgba(180,200,255,0.28)" stroke-width="0.8"/>
        
        <line x1="42" y1="181" x2="199" y2="181" stroke="rgba(200,220,255,0.28)" stroke-width="1.2"/>
        
        <!-- CHAMBER 6 -->
        <rect class="chamber c6" x="42" y="189" width="45" height="80" rx="2" fill="url(#chamberGlow)" stroke="rgba(180,200,255,0.28)" stroke-width="0.8"/>
        <!-- CHAMBER 7 - reinforcement steel -->
        <rect class="chamber c7" x="95" y="189" width="38" height="80" rx="2" fill="rgba(90,110,160,0.12)" stroke="rgba(160,180,220,0.3)" stroke-width="1"/>
        <!-- Steel insert icon -->
        <rect x="101" y="198" width="26" height="62" rx="1" fill="none" stroke="rgba(200,220,255,0.18)" stroke-width="1.5" stroke-dasharray="4 3"/>
        <!-- CHAMBER 8 -->
        <rect class="chamber c8" x="141" y="189" width="58" height="80" rx="2" fill="url(#chamberGlow)" stroke="rgba(180,200,255,0.28)" stroke-width="0.8"/>
        
        <line x1="42" y1="277" x2="199" y2="277" stroke="rgba(200,220,255,0.28)" stroke-width="1.2"/>
        
        <!-- CHAMBER 9 -->
        <rect class="chamber c9" x="42" y="285" width="90" height="60" rx="2" fill="url(#chamberGlow)" stroke="rgba(180,200,255,0.28)" stroke-width="0.8"/>
        <!-- CHAMBER 10 -->
        <rect class="chamber c10" x="140" y="285" width="59" height="60" rx="2" fill="url(#chamberGlow)" stroke="rgba(180,200,255,0.28)" stroke-width="0.8"/>
        
        <line x1="42" y1="353" x2="199" y2="353" stroke="rgba(200,220,255,0.28)" stroke-width="1.2"/>
        
        <!-- CHAMBER 11 - bottom large -->
        <rect class="chamber c11" x="42" y="361" width="157" height="88" rx="2" fill="url(#chamberGlow)" stroke="rgba(180,200,255,0.28)" stroke-width="0.8"/>

        <!-- Seals / Gaskets (EPDM) -->
        <circle cx="205" cy="80" r="6" fill="rgba(30,60,120,0.3)" stroke="rgba(100,120,180,0.4)" stroke-width="1">
          <animate attributeName="r" values="6;7;6" dur="3s" repeatCount="indefinite"/>
        </circle>
        <circle cx="205" cy="240" r="6" fill="rgba(30,60,120,0.3)" stroke="rgba(100,120,180,0.4)" stroke-width="1">
          <animate attributeName="r" values="6;7;6" dur="3s" begin="1s" repeatCount="indefinite"/>
        </circle>
        <circle cx="205" cy="400" r="6" fill="rgba(30,60,120,0.3)" stroke="rgba(100,120,180,0.4)" stroke-width="1">
          <animate attributeName="r" values="6;7;6" dur="3s" begin="2s" repeatCount="indefinite"/>
        </circle>

        <!-- Glass pane (inside) -->
        <rect x="36" y="28" width="3" height="425" rx="1.5" fill="url(#glass)" stroke="rgba(160,200,255,0.35)" stroke-width="0.5"/>
      </g>

      <!-- ========== THERMAL BARRIER (center) ========== -->
      <g class="profile-thermal">
        <rect x="215" y="15" width="90" height="450" rx="3" fill="url(#thermal)"/>
        <!-- Polyamide bridges -->
        <rect x="223" y="20" width="8" height="440" rx="1" fill="rgba(25,62,234,0.12)" stroke="rgba(25,62,234,0.2)" stroke-width="0.5"/>
        <rect x="289" y="20" width="8" height="440" rx="1" fill="rgba(25,62,234,0.12)" stroke="rgba(25,62,234,0.2)" stroke-width="0.5"/>
        <!-- Insulation fill pattern -->
        <g class="thermal-waves" opacity="0.85">
          <path d="M240 30 c8 12, 8 12, 0 24 s0 24, 8 36 c-8 12,-8 12, 0 24 s0 24,-8 36 c8 12, 8 12, 0 24 s0 24, 8 36 c-8 12,-8 12, 0 24 s0 24,-8 36 c8 12, 8 12, 0 24 s0 24, 8 36 c-8 12,-8 12, 0 24 s0 24,-8 36" stroke="rgba(25,62,234,0.55)" stroke-width="1.8" fill="none">
            <animate attributeName="stroke-opacity" values="0.3;0.7;0.3" dur="3s" repeatCount="indefinite"/>
          </path>
          <path d="M260 25 c-6 14, 6 14, 0 28 s6 28, 0 42 c6 14,-6 14, 0 28 s-6 28, 0 42 c6 14,-6 14, 0 28 s-6 28, 0 42 c6 14,-6 14, 0 28 s-6 28, 0 42 c6 14,-6 14, 0 28" stroke="rgba(25,62,234,0.45)" stroke-width="1.3" fill="none">
            <animate attributeName="stroke-opacity" values="0.2;0.6;0.2" dur="4s" begin="1s" repeatCount="indefinite"/>
          </path>
          <path d="M280 35 c7 10, -7 20, 0 30 s-7 20, 7 30 c-7 10, 7 20, 0 30 s7 20, -7 30 c7 10, -7 20, 0 30 s-7 20, 7 30 c-7 10, 7 20, 0 30 s7 20, -7 30" stroke="rgba(25,62,234,0.5)" stroke-width="1.5" fill="none">
            <animate attributeName="stroke-opacity" values="0.25;0.65;0.25" dur="3.5s" begin="0.5s" repeatCount="indefinite"/>
          </path>
        </g>
        <!-- Pulsing thermal glow -->
        <rect x="220" y="15" width="80" height="450" rx="3" fill="none" stroke="rgba(25,62,234,0.3)" stroke-width="1" filter="url(#glow)">
          <animate attributeName="stroke-opacity" values="0.1;0.4;0.1" dur="4s" repeatCount="indefinite"/>
        </rect>
      </g>

      <!-- ========== RIGHT FRAME (РАМА) ========== -->
      <g class="profile-right">
        <path d="M310 20 h180 v440 h-180 Z" fill="url(#alum)" stroke="url(#alumEdge)" stroke-width="1.2"/>
        <!-- Outer lip -->
        <path d="M495 15 h10 v450 h-10 Z" fill="rgba(180,200,240,0.2)" stroke="rgba(200,220,255,0.35)" stroke-width="0.8"/>
        <path d="M500 30 v420" stroke="rgba(255,255,255,0.14)" stroke-width="0.5"/>

        <!-- Chambers right side -->
        <rect class="chamber cr1" x="322" y="32" width="50" height="70" rx="2" fill="url(#chamberGlow)" stroke="rgba(180,200,255,0.28)" stroke-width="0.8"/>
        <rect class="chamber cr2" x="380" y="32" width="46" height="70" rx="2" fill="url(#chamberGlow)" stroke="rgba(180,200,255,0.28)" stroke-width="0.8"/>
        <rect class="chamber cr3" x="434" y="32" width="45" height="70" rx="2" fill="url(#chamberGlow)" stroke="rgba(180,200,255,0.28)" stroke-width="0.8"/>
        
        <line x1="322" y1="110" x2="479" y2="110" stroke="rgba(200,220,255,0.28)" stroke-width="1.2"/>
        
        <rect class="chamber cr4" x="322" y="118" width="72" height="55" rx="2" fill="url(#chamberGlow)" stroke="rgba(180,200,255,0.28)" stroke-width="0.8"/>
        <rect class="chamber cr5" x="402" y="118" width="77" height="55" rx="2" fill="url(#chamberGlow)" stroke="rgba(180,200,255,0.28)" stroke-width="0.8"/>
        
        <line x1="322" y1="181" x2="479" y2="181" stroke="rgba(200,220,255,0.28)" stroke-width="1.2"/>
        
        <rect class="chamber cr6" x="322" y="189" width="52" height="80" rx="2" fill="url(#chamberGlow)" stroke="rgba(180,200,255,0.28)" stroke-width="0.8"/>
        <!-- Steel reinforcement right -->
        <rect class="chamber cr7" x="382" y="189" width="36" height="80" rx="2" fill="rgba(90,110,160,0.12)" stroke="rgba(160,180,220,0.3)" stroke-width="1"/>
        <rect x="388" y="198" width="24" height="62" rx="1" fill="none" stroke="rgba(200,220,255,0.18)" stroke-width="1.5" stroke-dasharray="4 3"/>
        <rect class="chamber cr8" x="426" y="189" width="53" height="80" rx="2" fill="url(#chamberGlow)" stroke="rgba(180,200,255,0.28)" stroke-width="0.8"/>
        
        <line x1="322" y1="277" x2="479" y2="277" stroke="rgba(200,220,255,0.28)" stroke-width="1.2"/>
        
        <rect class="chamber cr9" x="322" y="285" width="80" height="60" rx="2" fill="url(#chamberGlow)" stroke="rgba(180,200,255,0.28)" stroke-width="0.8"/>
        <rect class="chamber cr10" x="410" y="285" width="69" height="60" rx="2" fill="url(#chamberGlow)" stroke="rgba(180,200,255,0.28)" stroke-width="0.8"/>
        
        <line x1="322" y1="353" x2="479" y2="353" stroke="rgba(200,220,255,0.28)" stroke-width="1.2"/>
        
        <rect class="chamber cr11" x="322" y="361" width="157" height="88" rx="2" fill="url(#chamberGlow)" stroke="rgba(180,200,255,0.28)" stroke-width="0.8"/>

        <!-- Seals right -->
        <circle cx="315" cy="80" r="6" fill="rgba(30,60,120,0.3)" stroke="rgba(100,120,180,0.4)" stroke-width="1">
          <animate attributeName="r" values="6;7;6" dur="3s" begin="0.5s" repeatCount="indefinite"/>
        </circle>
        <circle cx="315" cy="240" r="6" fill="rgba(30,60,120,0.3)" stroke="rgba(100,120,180,0.4)" stroke-width="1">
          <animate attributeName="r" values="6;7;6" dur="3s" begin="1.5s" repeatCount="indefinite"/>
        </circle>
        <circle cx="315" cy="400" r="6" fill="rgba(30,60,120,0.3)" stroke="rgba(100,120,180,0.4)" stroke-width="1">
          <animate attributeName="r" values="6;7;6" dur="3s" begin="2.5s" repeatCount="indefinite"/>
        </circle>

        <!-- Glass pane right -->
        <rect x="483" y="28" width="3" height="425" rx="1.5" fill="url(#glass)" stroke="rgba(160,200,255,0.35)" stroke-width="0.5"/>
      </g>

      <!-- ========== DIMENSION LINES ========== -->
      <g class="dim-lines" opacity="0.6">
        <!-- Total width -->
        <line x1="20" y1="475" x2="505" y2="475" stroke="rgba(255,255,255,0.4)" stroke-width="0.5" stroke-dasharray="4 3"/>
        <line x1="20" y1="470" x2="20" y2="480" stroke="rgba(255,255,255,0.4)" stroke-width="0.7"/>
        <line x1="505" y1="470" x2="505" y2="480" stroke="rgba(255,255,255,0.4)" stroke-width="0.7"/>
        
        <!-- Thermal barrier width -->
        <line x1="215" y1="7" x2="305" y2="7" stroke="rgba(25,62,234,0.5)" stroke-width="0.5"/>
        <line x1="215" y1="3" x2="215" y2="11" stroke="rgba(25,62,234,0.5)" stroke-width="0.7"/>
        <line x1="305" y1="3" x2="305" y2="11" stroke="rgba(25,62,234,0.5)" stroke-width="0.7"/>
      </g>

      <!-- ========== CHAMBER GLOW ANIMATION (sequential light-up) ========== -->
      <g class="chamber-pulse">
        <rect x="42" y="32" width="55" height="70" rx="2" fill="rgba(25,62,234,0.12)">
          <animate attributeName="fill-opacity" values="0;0.8;0" dur="6s" begin="0s" repeatCount="indefinite"/>
        </rect>
        <rect x="155" y="32" width="44" height="70" rx="2" fill="rgba(25,62,234,0.12)">
          <animate attributeName="fill-opacity" values="0;0.8;0" dur="6s" begin="0.5s" repeatCount="indefinite"/>
        </rect>
        <rect x="42" y="118" width="80" height="55" rx="2" fill="rgba(25,62,234,0.12)">
          <animate attributeName="fill-opacity" values="0;0.8;0" dur="6s" begin="1s" repeatCount="indefinite"/>
        </rect>
        <rect x="141" y="189" width="58" height="80" rx="2" fill="rgba(25,62,234,0.12)">
          <animate attributeName="fill-opacity" values="0;0.8;0" dur="6s" begin="1.5s" repeatCount="indefinite"/>
        </rect>
        <rect x="322" y="32" width="50" height="70" rx="2" fill="rgba(25,62,234,0.12)">
          <animate attributeName="fill-opacity" values="0;0.8;0" dur="6s" begin="2s" repeatCount="indefinite"/>
        </rect>
        <rect x="434" y="32" width="45" height="70" rx="2" fill="rgba(25,62,234,0.12)">
          <animate attributeName="fill-opacity" values="0;0.8;0" dur="6s" begin="2.5s" repeatCount="indefinite"/>
        </rect>
        <rect x="402" y="118" width="77" height="55" rx="2" fill="rgba(25,62,234,0.12)">
          <animate attributeName="fill-opacity" values="0;0.8;0" dur="6s" begin="3s" repeatCount="indefinite"/>
        </rect>
        <rect x="426" y="189" width="53" height="80" rx="2" fill="rgba(25,62,234,0.12)">
          <animate attributeName="fill-opacity" values="0;0.8;0" dur="6s" begin="3.5s" repeatCount="indefinite"/>
        </rect>
      </g>
    </svg>

    <div class="profile-scan-line"></div>

    <div class="hero-particles">
      <div class="hero-particle"></div><div class="hero-particle"></div><div class="hero-particle"></div>
      <div class="hero-particle"></div><div class="hero-particle"></div><div class="hero-particle"></div>
    </div>
  </div>

  <!-- Annotation tags -->
  <div class="profile-annotation profile-annotation-1">
    <div class="annotation-tag"><span class="annotation-dot"></span>Полиамидный термобарьер 51 мм</div>
  </div>
  <div class="profile-annotation profile-annotation-2">
    <div class="annotation-tag"><span class="annotation-dot"></span>Уплотнитель EPDM</div>
  </div>
  <div class="profile-annotation profile-annotation-3">
    <div class="annotation-tag"><span class="annotation-dot"></span>Стеклопакет до 68 мм</div>
  </div>

  <div class="container">

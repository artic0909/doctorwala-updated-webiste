import os
import re

directory = 'resources/views/partnerpanel/'
for root, _, files in os.walk(directory):
    for filename in files:
        if filename.endswith('.blade.php'):
            filepath = os.path.join(root, filename)
            with open(filepath, 'r') as f:
                content = f.read()

            # First, check if the Profile block exists
            if 'partner-profile' in content:
                # Add List Myself under Profile
                # Find the end of the ui-basic list
                profile_end_pattern = re.compile(r'(@if\(in_array\(\'Pathology\',\s*\$registrationTypes\)\)\s*<li class="nav-item">\s*<a class="nav-link"\s*href="/partnerpanel/partner-pathology-contact">Pathology Contact</a></li>\s*@endif\s*</ul>\s*</div>\s*</li>)', re.DOTALL)
                
                replacement_profile = r"""@if(in_array('Pathology', $registrationTypes))
                                <li class="nav-item"> <a class="nav-link"
                                        href="/partnerpanel/partner-pathology-contact">Pathology Contact</a></li>
                                @endif

                                @if(in_array('Doctor', $registrationTypes))
                                <li class="nav-item"> <a class="nav-link"
                                        href="/partnerpanel/partner-doctors">List Myself</a></li>
                                @endif
                            </ul>
                        </div>
                    </li>"""
                
                # Check if it was already updated
                if 'List Myself' not in content:
                    content = profile_end_pattern.sub(replacement_profile, content)
                
                # Remove the Doctors block
                doctor_block_pattern = re.compile(r'@if\(in_array\(\'Doctor\',\s*\$registrationTypes\)\)\s*<!-- Doctors -->.*?</li>\s*@endif', re.DOTALL)
                content = doctor_block_pattern.sub('', content)

                with open(filepath, 'w') as f:
                    f.write(content)
                print(f"Updated {filepath}")
